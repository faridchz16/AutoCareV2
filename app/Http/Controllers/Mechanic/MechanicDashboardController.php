<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;

class MechanicDashboardController extends Controller
{
    public function index()
    {
        $mechanicId = auth()->id();

        $assignedJobs = ServiceRequest::where('mechanic_id', $mechanicId)
            ->count();

        $inProgressJobs = ServiceRequest::where('mechanic_id', $mechanicId)
            ->where('status', 'en_proceso')
            ->count();

        $completedJobs = ServiceRequest::where('mechanic_id', $mechanicId)
            ->where('mechanic_finished', true)
            ->count();

        $todayJobs = ServiceRequest::where('mechanic_id', $mechanicId)
            ->whereHas('serviceDate', function ($query) {
                $query->whereDate('available_date', today());
            })
            ->count();

        $recentJobs = ServiceRequest::with([
                'customer',
                'serviceType',
                'serviceDate'
            ])
            ->where('mechanic_id', $mechanicId)
            ->latest()
            ->take(5)
            ->get();

        return view('mechanic.dashboard', compact(
            'assignedJobs',
            'inProgressJobs',
            'completedJobs',
            'todayJobs',
            'recentJobs'
        ));
    }
}