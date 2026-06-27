<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $vehicleTypes = VehicleType::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('name')
            ->paginate(8)
            ->withQueryString();

        $totalVehicleTypes = VehicleType::count();
        $activeVehicleTypes = VehicleType::where('status', 'activo')->count();
        $inactiveVehicleTypes = VehicleType::where('status', 'inactivo')->count();

        return view('admin.vehicle-types.index', compact(
            'vehicleTypes',
            'totalVehicleTypes',
            'activeVehicleTypes',
            'inactiveVehicleTypes',
            'search',
            'status'
        ));
    }

    public function create()
    {
        return view('admin.vehicle-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        VehicleType::create($data);

        return redirect()
            ->route('admin.vehicle-types.index')
            ->with('success', 'El tipo de vehículo fue registrado correctamente.');
    }

    public function show(VehicleType $vehicleType)
    {
        return view('admin.vehicle-types.show', compact('vehicleType'));
    }

    public function edit(VehicleType $vehicleType)
    {
        return view('admin.vehicle-types.edit', compact('vehicleType'));
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $data = $request->validate($this->rules($vehicleType->id), $this->messages());

        $vehicleType->update($data);

        return redirect()
            ->route('admin.vehicle-types.index')
            ->with('success', 'El tipo de vehículo fue actualizado correctamente.');
    }

    private function rules($id = null): array
    {
        return [
            'name' => 'required|string|max:100|unique:vehicle_types,name,' . $id,
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:activo,inactivo',
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Debe ingresar el nombre del tipo de vehículo.',
            'name.unique' => 'Este tipo de vehículo ya está registrado.',
            'description.max' => 'La descripción no puede superar los 255 caracteres.',
            'status.required' => 'Debe seleccionar un estado.',
            'status.in' => 'El estado seleccionado no es válido.',
        ];
    }
}