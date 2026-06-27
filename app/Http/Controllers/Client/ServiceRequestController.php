<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\ServiceDate;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = ServiceRequest::with([
                'serviceType',
                'serviceDate',
                'paymentMethod',
                'mechanic'
            ])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('client.service-requests.index', compact('requests'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())
            ->where('status', 'activo')
            ->orderBy('brand')
            ->get();

        $services = ServiceType::where('status', 'activo')
            ->orderBy('name')
            ->get();

        $dates = ServiceDate::with('serviceType')
            ->where('status', 'disponible')
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        $paymentMethods = PaymentMethod::where('status', 'activo')
            ->orderBy('name')
            ->get();

        return view('client.service-requests.create', compact(
            'vehicles',
            'services',
            'dates',
            'paymentMethods'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_type_id' => 'required|exists:service_types,id',
            'service_date_id' => 'required|exists:service_dates,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'customer_notes' => 'nullable|string|max:500',
        ], [
            'vehicle_id.required' => 'Debe seleccionar un vehículo.',
            'service_type_id.required' => 'Debe seleccionar un servicio.',
            'service_date_id.required' => 'Debe seleccionar una fecha disponible.',
            'payment_method_id.required' => 'Debe seleccionar una forma de pago.',
            'customer_notes.max' => 'Las observaciones no pueden superar los 500 caracteres.',
        ]);

        try {
            $vehicle = Vehicle::where('id', $data['vehicle_id'])
                ->where('user_id', auth()->id())
                ->where('status', 'activo')
                ->firstOrFail();

            $service = ServiceType::where('id', $data['service_type_id'])
                ->where('status', 'activo')
                ->firstOrFail();

            $date = ServiceDate::where('id', $data['service_date_id'])
                ->where('status', 'disponible')
                ->firstOrFail();

            $paymentMethod = PaymentMethod::where('id', $data['payment_method_id'])
                ->where('status', 'activo')
                ->firstOrFail();

            $prices = [
                'Cambio de aceite y filtro' => 120,
                'Mantenimiento preventivo' => 180,
                'Revisión del sistema de frenos' => 150,
                'Diagnóstico computarizado' => 100,
                'Cambio de batería' => 250,
                'Alineamiento y balanceo' => 90,
                'Cambio de bujías' => 130,
                'Revisión del sistema de refrigeración' => 140,
                'Cambio de filtro de aire' => 80,
                'Lavado de inyectores' => 160,
            ];

            $amount = $prices[$service->name] ?? 100;

            ServiceRequest::create([
                'user_id' => auth()->id(),
                'service_type_id' => $service->id,
                'service_date_id' => $date->id,
                'payment_method_id' => $paymentMethod->id,
                'mechanic_id' => null,

                'amount' => $amount,

                'vehicle_plate' => $vehicle->plate,
                'vehicle_brand' => $vehicle->brand,
                'vehicle_model' => $vehicle->model,
                'vehicle_year' => $vehicle->year,
                'current_mileage' => $vehicle->current_mileage,

                'customer_notes' => $data['customer_notes'] ?? null,
                'admin_notes' => null,

                'status' => 'pendiente',
                'payment_status' => 'pendiente',
                'mechanic_finished' => false,
                'admin_confirmed' => false,
            ]);

            $date->update([
                'status' => 'reservado',
            ]);

            return redirect()
                ->route('client.service-requests.index')
                ->with('success', 'La solicitud de mantenimiento fue registrada correctamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo registrar la solicitud. Verifique los datos e inténtelo nuevamente.');
        }
    }

    public function show(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->user_id !== auth()->id()) {
            abort(403, 'No tiene permiso para ver esta solicitud.');
        }

        $serviceRequest->load([
            'serviceType',
            'serviceDate',
            'paymentMethod',
            'mechanic'
        ]);

        return view('client.service-requests.show', compact('serviceRequest'));
    }
}