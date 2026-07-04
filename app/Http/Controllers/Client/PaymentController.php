<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
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
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('client.payments.index', compact('payments'));
    }

    public function checkout(ServiceRequest $serviceRequest)
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

        $publicKey = config('services.mercadopago.public_key');

        return view('client.payments.checkout', compact(
            'serviceRequest',
            'publicKey'
        ));
    }

    public function process(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->user_id !== auth()->id()) {
            abort(403);
        }

        if ($serviceRequest->payment_status === 'pagado') {
            return response()->json([
                'success' => true,
                'message' => 'Este pago ya fue realizado.',
                'redirect_url' => route('client.payments.success', $serviceRequest),
            ]);
        }

        $data = $request->validate([
            'token' => 'required|string',
            'payment_method_id' => 'required|string',
            'issuer_id' => 'nullable',
            'installments' => 'required|integer|min:1',
            'payer.email' => 'required|email',
            'payer.identification.type' => 'nullable|string',
            'payer.identification.number' => 'nullable|string',
        ]);

        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

            $client = new PaymentClient();

            $requestOptions = new RequestOptions();
            $requestOptions->setCustomHeaders([
                'X-Idempotency-Key: ' . (string) Str::uuid(),
            ]);

            $paymentData = [
                'transaction_amount' => (float) $serviceRequest->amount,
                'token' => $data['token'],
                'description' => $serviceRequest->serviceType->name ?? 'Servicio AutoCare',
                'installments' => (int) $data['installments'],
                'payment_method_id' => $data['payment_method_id'],
                'payer' => [
                    'email' => $data['payer']['email'],
                    'identification' => [
                        'type' => $data['payer']['identification']['type'] ?? 'DNI',
                        'number' => $data['payer']['identification']['number'] ?? '12345678',
                    ],
                ],
                'external_reference' => (string) $serviceRequest->id,
            ];

            if (!empty($data['issuer_id'])) {
                $paymentData['issuer_id'] = $data['issuer_id'];
            }

            $payment = $client->create($paymentData, $requestOptions);

            if ($payment->status === 'approved') {
                $serviceRequest->update([
                    'payment_status' => 'pagado',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Pago aprobado correctamente.',
                    'redirect_url' => route('client.payments.success', $serviceRequest),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'El pago quedó en estado: ' . $payment->status,
                'redirect_url' => route('client.payments.pending', $serviceRequest),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
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