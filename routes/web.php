<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\ServiceDateController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\VehicleTypeController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;

use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\VehicleController;
use App\Http\Controllers\Client\ServiceRequestController as ClientServiceRequestController;
use App\Http\Controllers\Client\PaymentController as ClientPaymentController;

use App\Http\Controllers\Mechanic\MechanicDashboardController;
use App\Http\Controllers\Mechanic\JobController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {

        if (auth()->user()->role === 'administrador') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->role === 'mecanico') {
            return redirect()->route('mechanic.dashboard');
        }

        return redirect()->route('client.dashboard');

    })->name('dashboard');


    Route::middleware(['admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('services', ServiceTypeController::class)
                ->except(['destroy']);


            Route::resource('service-dates', ServiceDateController::class)
                ->parameters([
                    'service-dates' => 'serviceDate'
                ])
                ->except(['destroy']);


            Route::resource('payment-methods', PaymentMethodController::class)
                ->except(['destroy']);


            Route::resource('vehicle-types', VehicleTypeController::class)
                ->except(['destroy']);


            Route::get('service-requests', [AdminServiceRequestController::class, 'index'])
                ->name('service-requests.index');

            Route::get('service-requests/{serviceRequest}', [AdminServiceRequestController::class, 'show'])
                ->name('service-requests.show');

            Route::put('service-requests/{serviceRequest}', [AdminServiceRequestController::class, 'update'])
                ->name('service-requests.update');

        });


    Route::middleware(['client'])
        ->prefix('cliente')
        ->name('client.')
        ->group(function () {

            Route::get('/dashboard', [ClientDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('vehicles', [VehicleController::class, 'index'])
                ->name('vehicles.index');

            Route::get('vehicles/create', [VehicleController::class, 'create'])
                ->name('vehicles.create');

            Route::post('vehicles', [VehicleController::class, 'store'])
                ->name('vehicles.store');

            Route::get('service-requests', [ClientServiceRequestController::class, 'index'])
                ->name('service-requests.index');

            Route::get('service-requests/create', [ClientServiceRequestController::class, 'create'])
                ->name('service-requests.create');

            Route::post('service-requests', [ClientServiceRequestController::class, 'store'])
                ->name('service-requests.store');

            Route::get('service-requests/{serviceRequest}', [ClientServiceRequestController::class, 'show'])
                ->name('service-requests.show');

            Route::get('payments', [ClientPaymentController::class, 'index'])
                ->name('payments.index');
            Route::post('payments/{serviceRequest}/pay', [ClientPaymentController::class, 'pay'])
                ->name('payments.pay');

            Route::get('payments/{serviceRequest}/success', [ClientPaymentController::class, 'success'])
                ->name('payments.success');

            Route::get('payments/{serviceRequest}/failure', [ClientPaymentController::class, 'failure'])
                ->name('payments.failure');

            Route::get('payments/{serviceRequest}/pending', [ClientPaymentController::class, 'pending'])
                ->name('payments.pending');
        });


    Route::middleware(['mechanic'])
        ->prefix('mecanico')
        ->name('mechanic.')
        ->group(function () {

            Route::get('/dashboard', [MechanicDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('jobs', [JobController::class, 'index'])
                ->name('jobs.index');

            Route::get('jobs/{serviceRequest}', [JobController::class, 'show'])
                ->name('jobs.show');

            Route::put('jobs/{serviceRequest}', [JobController::class, 'update'])
                ->name('jobs.update');

        });

});