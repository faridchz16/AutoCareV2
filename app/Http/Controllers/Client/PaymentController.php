<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = ServiceRequest::with([
                'serviceType',
                'paymentMethod'
            ])
            ->where('user_id', auth()->id())
            ->where('payment_status', 'pendiente')
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('client.payments.index', compact('payments'));
    }

    public function pay(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->user_id !== auth()->id()) {
            abort(403);
        }

        if ($serviceRequest->payment_status === 'pagado') {
            return redirect()
                ->route('client.payments.index')
                ->with('success', 'Este pago ya fue realizado.');
        }

        if (!$serviceRequest->amount || $serviceRequest->amount <= 0) {
            return redirect()
                ->route('client.payments.index')
                ->with('error', 'El monto del pago no es válido.');
        }

        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

            $client = new PreferenceClient();

            $preference = $client->create([
                'items' => [
                    [
                        'title' => $serviceRequest->serviceType->name ?? 'Servicio AutoCare',
                        'quantity' => 1,
                        'unit_price' => (float) $serviceRequest->amount,
                        'currency_id' => 'PEN',
                    ],
                ],
                'external_reference' => (string) $serviceRequest->id,
                'back_urls' => [
                'success' => url('/cliente/payments/' . $serviceRequest->id . '/success'),
                'failure' => url('/cliente/payments/' . $serviceRequest->id . '/failure'),
                'pending' => url('/cliente/payments/' . $serviceRequest->id . '/pending'),
            ],
            ]);

            return redirect()->away($preference->init_point);

        } catch (\Exception $e) {
            dd([
                'mensaje' => $e->getMessage(),
                'clase' => get_class($e),
                'codigo' => $e->getCode(),
                'archivo' => $e->getFile(),
                'linea' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
}
    }

    public function success(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->user_id !== auth()->id()) {
            abort(403);
        }

        $serviceRequest->update([
            'payment_status' => 'pagado',
        ]);

        return redirect()
            ->route('client.payments.index')
            ->with('success', 'Pago realizado correctamente.');
    }

    public function failure(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()
            ->route('client.payments.index')
            ->with('error', 'El pago no fue completado.');
    }

    public function pending(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()
            ->route('client.payments.index')
            ->with('error', 'El pago quedó pendiente de confirmación.');
    }
}