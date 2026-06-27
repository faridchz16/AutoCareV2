<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $status = $request->input('status');
            $paymentStatus = $request->input('payment_status');

            $requests = ServiceRequest::with([
                    'customer',
                    'mechanic',
                    'serviceType',
                    'serviceDate',
                    'paymentMethod'
                ])
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery->where('vehicle_brand', 'like', '%' . $search . '%')
                            ->orWhere('vehicle_model', 'like', '%' . $search . '%')
                            ->orWhere('vehicle_plate', 'like', '%' . $search . '%')
                            ->orWhereHas('customer', function ($customerQuery) use ($search) {
                                $customerQuery->where('name', 'like', '%' . $search . '%');
                            })
                            ->orWhereHas('serviceType', function ($serviceQuery) use ($search) {
                                $serviceQuery->where('name', 'like', '%' . $search . '%');
                            });
                    });
                })
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($paymentStatus, function ($query) use ($paymentStatus) {
                    $query->where('payment_status', $paymentStatus);
                })
                ->orderByDesc('created_at')
                ->paginate(8)
                ->withQueryString();

            $totalRequests = ServiceRequest::count();
            $pendingRequests = ServiceRequest::where('status', 'pendiente')->count();

            $processRequests = ServiceRequest::whereIn('status', [
                'en_taller',
                'en_proceso'
            ])->count();

            $readyRequests = ServiceRequest::whereIn('status', [
                'listo_para_recoger'
            ])->count();

            $pendingPayments = ServiceRequest::where('payment_status', 'pendiente')->count();

            return view('admin.service-requests.index', compact(
                'requests',
                'totalRequests',
                'pendingRequests',
                'processRequests',
                'readyRequests',
                'pendingPayments',
                'search',
                'status',
                'paymentStatus'
            ));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'No se pudo cargar la gestión de solicitudes de atención.');
        }
    }

    public function show(ServiceRequest $serviceRequest)
    {
        try {
            $serviceRequest->load([
                'customer',
                'mechanic',
                'serviceType',
                'serviceDate',
                'paymentMethod'
            ]);

            $mechanics = User::where('role', 'mecanico')
                ->where('status', 'activo')
                ->orderBy('name')
                ->get();

            return view('admin.service-requests.show', compact('serviceRequest', 'mechanics'));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.service-requests.index')
                ->with('error', 'No se pudo mostrar el detalle de la solicitud.');
        }
    }

    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $data = $request->validate([
            'mechanic_id' => 'nullable|exists:users,id',
            'amount' => 'nullable|numeric|min:0|max:999999.99',
            'status' => 'required|in:pendiente,confirmado,en_taller,en_proceso,finalizado_mecanico,validado_administrador,listo_para_recoger,cancelado',
            'payment_status' => 'required|in:pendiente,pagado,validado,observado,reembolsado',
            'admin_notes' => 'nullable|string|max:500',
            'admin_confirmed' => 'nullable|boolean',
        ], [
            'mechanic_id.exists' => 'El mecánico seleccionado no existe.',
            'amount.numeric' => 'El costo debe ser un valor numérico.',
            'amount.min' => 'El costo no puede ser negativo.',
            'amount.max' => 'El costo ingresado es demasiado alto.',
            'status.required' => 'Debe seleccionar un estado del servicio.',
            'status.in' => 'El estado del servicio seleccionado no es válido.',
            'payment_status.required' => 'Debe seleccionar un estado del pago.',
            'payment_status.in' => 'El estado del pago seleccionado no es válido.',
            'admin_notes.max' => 'Las observaciones no pueden superar los 500 caracteres.',
        ]);

        try {
            $data['admin_confirmed'] = $request->has('admin_confirmed');

            if ($data['admin_confirmed'] && $serviceRequest->mechanic_finished) {
                $data['status'] = 'listo_para_recoger';
            }

            $serviceRequest->update($data);

            return redirect()
                ->route('admin.service-requests.show', $serviceRequest)
                ->with('success', 'La solicitud fue actualizada correctamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo actualizar la solicitud. Inténtelo nuevamente.');
        }
    }
}