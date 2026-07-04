<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceDate;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceDateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $status = $request->input('status');

            $dates = ServiceDate::with('serviceType')
                ->when($search, function ($query) use ($search) {
                    $query->whereHas('serviceType', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', '%' . $search . '%');
                    });
                })
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderBy('available_date')
                ->orderBy('start_time')
                ->paginate(8)
                ->withQueryString();

            $totalDates = ServiceDate::count();
            $availableDates = ServiceDate::where('status', 'disponible')->count();
            $reservedDates = ServiceDate::where('status', 'reservado')->count();
            $blockedDates = ServiceDate::where('status', 'no_disponible')->count();

            return view('admin.service-dates.index', compact(
                'dates',
                'totalDates',
                'availableDates',
                'reservedDates',
                'blockedDates',
                'search',
                'status'
            ));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'No se pudo cargar la gestión de fechas disponibles.');
        }
    }

    public function create()
    {
        try {
            $services = ServiceType::where('status', 'activo')
                ->orderBy('name')
                ->get();

            return view('admin.service-dates.create', compact('services'));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.service-dates.index')
                ->with('error', 'No se pudo cargar el formulario de fechas disponibles.');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            if ($data['start_time'] >= $data['end_time']) {
                return back()
                    ->withInput()
                    ->with('error', 'La hora de inicio debe ser menor que la hora de fin.');
            }

            $data['capacity'] = 1;

            ServiceDate::create($data);

            return redirect()
                ->route('admin.service-dates.index')
                ->with('success', 'La fecha de atención fue habilitada correctamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo habilitar la fecha. Verifique que no esté duplicada.');
        }
    }

    public function show(ServiceDate $serviceDate)
    {
        try {
            $serviceDate->load('serviceType');

            return view('admin.service-dates.show', compact('serviceDate'));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.service-dates.index')
                ->with('error', 'No se pudo mostrar el detalle de la fecha.');
        }
    }

    public function edit(ServiceDate $serviceDate)
    {
        try {
            $services = ServiceType::where('status', 'activo')
                ->orderBy('name')
                ->get();

            return view('admin.service-dates.edit', compact('serviceDate', 'services'));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.service-dates.index')
                ->with('error', 'No se pudo cargar la edición de la fecha.');
        }
    }

    public function update(Request $request, ServiceDate $serviceDate)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            if ($data['start_time'] >= $data['end_time']) {
                return back()
                    ->withInput()
                    ->with('error', 'La hora de inicio debe ser menor que la hora de fin.');
            }

            $data['capacity'] = 1;

            $serviceDate->update($data);

            return redirect()
                ->route('admin.service-dates.index')
                ->with('success', 'La fecha de atención fue actualizada correctamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo actualizar la fecha. Verifique que no esté duplicada.');
        }
    }

    private function rules(): array
    {
        return [
            'service_type_id' => 'required|exists:service_types,id',
            'available_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:disponible,reservado,no_disponible,cancelado',
        ];
    }

    private function messages(): array
    {
        return [
            'service_type_id.required' => 'Debe seleccionar un servicio.',
            'service_type_id.exists' => 'El servicio seleccionado no existe.',
            'available_date.required' => 'Debe ingresar una fecha de atención.',
            'available_date.date' => 'Debe ingresar una fecha válida.',
            'start_time.required' => 'Debe ingresar la hora de inicio.',
            'end_time.required' => 'Debe ingresar la hora de fin.',
            'status.required' => 'Debe seleccionar el estado de la fecha.',
            'status.in' => 'El estado seleccionado no es válido.',
        ];
    }
}