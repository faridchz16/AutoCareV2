<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = ServiceRequest::with([
                'customer',
                'serviceType',
                'serviceDate',
                'paymentMethod',
            ])
            ->where('mechanic_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('mechanic.jobs.index', compact('jobs'));
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $this->authorizeJob($serviceRequest);

        $serviceRequest->load([
            'customer',
            'serviceType',
            'serviceDate',
            'paymentMethod',
        ]);

        return view('mechanic.jobs.show', compact('serviceRequest'));
    }

    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $this->authorizeJob($serviceRequest);

        $data = $request->validate([
            'action' => 'required|in:start,finish',
        ]);

        if ($data['action'] === 'start') {
            $serviceRequest->update([
                'status' => 'en_proceso',
            ]);

            return redirect()
                ->route('mechanic.jobs.show', $serviceRequest)
                ->with('success', 'El trabajo fue iniciado correctamente.');
        }

        if ($data['action'] === 'finish') {
            $serviceRequest->update([
                'status' => 'finalizado_mecanico',
                'mechanic_finished' => true,
            ]);

            return redirect()
                ->route('mechanic.jobs.show', $serviceRequest)
                ->with('success', 'El trabajo fue finalizado correctamente.');
        }

        return back()->with('error', 'No se pudo actualizar el trabajo.');
    }

    private function authorizeJob(ServiceRequest $serviceRequest): void
    {
        if ($serviceRequest->mechanic_id !== auth()->id()) {
            abort(403, 'No tiene permiso para acceder a este trabajo.');
        }
    }
}