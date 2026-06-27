<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\ServiceDate;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $hour = Carbon::now()->format('H');

        if ($hour < 12) {
            $greeting = 'Buenos días';
        } elseif ($hour < 18) {
            $greeting = 'Buenas tardes';
        } else {
            $greeting = 'Buenas noches';
        }

        $totalServices = ServiceType::count();
        $activeServices = ServiceType::where('status', 'activo')->count();

        $availableDates = ServiceDate::where('status', 'disponible')->count();
        $blockedDates = ServiceDate::where('status', 'no_disponible')->count();

        $paymentMethods = PaymentMethod::where('status', 'activo')->count();

        $totalRequests = ServiceRequest::count();
        $pendingRequests = ServiceRequest::where('status', 'pendiente')->count();
        $processRequests = ServiceRequest::where('status', 'en_proceso')->count();
        $readyRequests = ServiceRequest::whereIn('status', ['terminado', 'listo'])->count();

        $activeMechanics = User::where('role', 'mecanico')
            ->where('status', 'activo')
            ->count();

        $latestServices = ServiceType::latest()
            ->take(4)
            ->get();

        $latestDates = ServiceDate::with('serviceType')
            ->latest()
            ->take(4)
            ->get();

        $latestRequests = ServiceRequest::with([
                'customer',
                'serviceType',
                'serviceDate'
            ])
            ->latest()
            ->take(5)
            ->get();

        $latestPayments = PaymentMethod::latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'greeting',
            'totalServices',
            'activeServices',
            'availableDates',
            'blockedDates',
            'paymentMethods',
            'totalRequests',
            'pendingRequests',
            'processRequests',
            'readyRequests',
            'activeMechanics',
            'latestServices',
            'latestDates',
            'latestRequests',
            'latestPayments'
        ));
    }
}