<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Vehicle;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalVehicles = Vehicle::where('user_id', $userId)
            ->where('status', 'activo')
            ->count();

        $activeRequests = ServiceRequest::where('user_id', $userId)
            ->whereNotIn('status', [
                'cancelado',
                'listo',
                'listo_para_recoger',
                'validado_administrador'
            ])
            ->count();

        $pendingPayments = ServiceRequest::where('user_id', $userId)
            ->where('payment_status', 'pendiente')
            ->count();

        $nextRequest = ServiceRequest::with(['serviceType', 'serviceDate', 'paymentMethod', 'mechanic'])
            ->where('user_id', $userId)
            ->whereHas('serviceDate')
            ->whereNotIn('status', ['cancelado'])
            ->orderByDesc('created_at')
            ->first();

        $latestRequests = ServiceRequest::with(['serviceType', 'serviceDate', 'paymentMethod', 'mechanic'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        $lastRequest = ServiceRequest::with(['serviceType', 'serviceDate', 'paymentMethod', 'mechanic'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->first();

        return view('client.dashboard', compact(
            'totalVehicles',
            'activeRequests',
            'pendingPayments',
            'nextRequest',
            'latestRequests',
            'lastRequest'
        ));
    }
}