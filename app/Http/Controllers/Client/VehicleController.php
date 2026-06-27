<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('vehicleType')
            ->where('user_id', auth()->id())
            ->where('status', 'activo')
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('client.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $vehicleTypes = VehicleType::where('status', 'activo')
            ->orderBy('name')
            ->get();

        return view('client.vehicles.create', compact('vehicleTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            $data['user_id'] = auth()->id();
            $data['plate'] = strtoupper($data['plate']);
            $data['status'] = 'activo';

            Vehicle::create($data);

            return redirect()
                ->route('client.vehicles.index')
                ->with('success', 'El vehículo fue registrado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo registrar el vehículo. Inténtelo nuevamente.');
        }
    }

    private function rules(): array
    {
        return [
            'plate' => 'required|string|max:20|unique:vehicles,plate',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'brand' => 'required|string|max:80',
            'model' => 'required|string|max:80',
            'year' => 'nullable|integer|min:1980|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
            'current_mileage' => 'nullable|integer|min:0',
        ];
    }

    private function messages(): array
    {
        return [
            'plate.required' => 'Debe ingresar la placa del vehículo.',
            'plate.unique' => 'Esta placa ya está registrada.',
            'vehicle_type_id.required' => 'Debe seleccionar un tipo de vehículo.',
            'vehicle_type_id.exists' => 'El tipo de vehículo seleccionado no es válido.',
            'brand.required' => 'Debe ingresar la marca del vehículo.',
            'model.required' => 'Debe ingresar el modelo del vehículo.',
            'year.integer' => 'El año debe ser un número válido.',
            'year.min' => 'El año ingresado no es válido.',
            'year.max' => 'El año ingresado no puede ser mayor al próximo año.',
            'current_mileage.integer' => 'El kilometraje debe ser un número entero.',
            'current_mileage.min' => 'El kilometraje no puede ser negativo.',
        ];
    }
}