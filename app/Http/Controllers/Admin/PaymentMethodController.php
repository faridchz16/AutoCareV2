<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $status = $request->input('status');

            $paymentMethods = PaymentMethod::query()
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

            $totalMethods = PaymentMethod::count();
            $activeMethods = PaymentMethod::where('status', 'activo')->count();
            $inactiveMethods = PaymentMethod::where('status', 'inactivo')->count();

            return view('admin.payment-methods.index', compact(
                'paymentMethods',
                'totalMethods',
                'activeMethods',
                'inactiveMethods',
                'search',
                'status'
            ));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'No se pudo cargar la gestión de formas de pago.');
        }
    }

    public function create()
    {
        try {
            return view('admin.payment-methods.create');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.payment-methods.index')
                ->with('error', 'No se pudo cargar el formulario de forma de pago.');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            PaymentMethod::create($data);

            return redirect()
                ->route('admin.payment-methods.index')
                ->with('success', 'La forma de pago fue registrada correctamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo registrar la forma de pago. Inténtelo nuevamente.');
        }
    }

    public function show(PaymentMethod $paymentMethod)
    {
        try {
            return view('admin.payment-methods.show', compact('paymentMethod'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.payment-methods.index')
                ->with('error', 'No se pudo mostrar el detalle de la forma de pago.');
        }
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        try {
            return view('admin.payment-methods.edit', compact('paymentMethod'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.payment-methods.index')
                ->with('error', 'No se pudo cargar la edición de la forma de pago.');
        }
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            $paymentMethod->update($data);

            return redirect()
                ->route('admin.payment-methods.index')
                ->with('success', 'La forma de pago fue actualizada correctamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo actualizar la forma de pago. Inténtelo nuevamente.');
        }
    }

    private function rules(): array
    {
        return [
            'name' => 'required|max:80',
            'description' => 'nullable|max:255',
            'status' => 'required|in:activo,inactivo',
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Debe ingresar el nombre.',
            'name.max' => 'El nombre no puede superar los 80 caracteres.',
            'description.max' => 'La descripción es demasiado larga.',
            'status.required' => 'Debe seleccionar un estado.',
            'status.in' => 'El estado seleccionado no es válido.',
        ];
    }
}