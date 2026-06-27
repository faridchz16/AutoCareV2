<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $status = $request->input('status');

            $services = ServiceType::query()
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%');
                    });
                })
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderBy('name')
                ->paginate(8)
                ->withQueryString();

            $totalServices = ServiceType::count();
            $activeServices = ServiceType::where('status', 'activo')->count();
            $inactiveServices = ServiceType::where('status', 'inactivo')->count();

            return view('admin.services.index', compact(
                'services',
                'totalServices',
                'activeServices',
                'inactiveServices',
                'search',
                'status'
            ));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'No se pudo cargar la gestión de servicios.');
        }
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            $data['base_price'] = 0;

            ServiceType::create($data);

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'El servicio fue registrado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo registrar el servicio. Inténtelo nuevamente.');
        }
    }

    public function edit(ServiceType $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, ServiceType $service)
    {
        $data = $request->validate($this->rules($service->id), $this->messages());

        try {
            $data['base_price'] = $service->base_price ?? 0;

            $service->update($data);

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'El servicio fue actualizado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo actualizar el servicio. Inténtelo nuevamente.');
        }
    }

    public function show(ServiceType $service)
    {
        return view('admin.services.show', compact('service'));
    }

    private function rules($id = null): array
    {
        return [
            'name' => 'required|string|max:120|unique:service_types,name,' . $id,
            'description' => 'nullable|string|max:500',
            'estimated_minutes' => 'required|integer|min:1',
            'status' => 'required|in:activo,inactivo',
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'El nombre del servicio es obligatorio.',
            'name.unique' => 'Ya existe un servicio registrado con ese nombre.',
            'estimated_minutes.required' => 'La duración estimada es obligatoria.',
            'estimated_minutes.integer' => 'La duración estimada debe ser un número entero.',
            'status.required' => 'Debe seleccionar un estado.',
        ];
    }
}