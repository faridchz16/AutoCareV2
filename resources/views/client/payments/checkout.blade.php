@extends('client.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Centro del cliente
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Pago del servicio
        </h1>

        <p class="text-slate-300 mt-2">
            Complete el pago directamente desde AutoCare.
        </p>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-1 rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-7">
            <h2 class="text-2xl font-extrabold text-white">
                Resumen
            </h2>

            <div class="mt-6 space-y-4 text-slate-300">
                <p>
                    <span class="text-cyan-300 font-bold">Servicio:</span>
                    {{ $serviceRequest->serviceType->name ?? 'Servicio AutoCare' }}
                </p>

                <p>
                    <span class="text-cyan-300 font-bold">Vehículo:</span>
                    {{ $serviceRequest->vehicle_brand }} {{ $serviceRequest->vehicle_model }}
                </p>

                <p>
                    <span class="text-cyan-300 font-bold">Placa:</span>
                    {{ $serviceRequest->vehicle_plate }}
                </p>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-slate-400">Monto a pagar</p>
                    <p class="text-4xl font-extrabold text-cyan-300 mt-2">
                        S/. {{ number_format($serviceRequest->amount, 2) }}
                    </p>
                </div>
            </div>

            <a href="{{ route('client.payments.index') }}"
               class="mt-6 inline-flex w-full justify-center rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold hover:bg-slate-600 transition">
                Volver a mis pagos
            </a>
        </div>

        <div class="xl:col-span-2 rounded-[32px] bg-white shadow-xl p-7">
            <h2 class="text-2xl font-extrabold text-slate-900 mb-4">
                Datos de pago
            </h2>

            <div id="paymentBrick_container"></div>

            <div id="payment-message" class="hidden mt-5 rounded-2xl px-5 py-4 font-semibold"></div>
        </div>

    </section>

</div>

<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
    const publicKey = @json($publicKey);
    const amount = @json((float) $serviceRequest->amount);
    const userEmail = @json(auth()->user()->email);

    function showMessage(message, type) {
        const box = document.getElementById("payment-message");

        box.className = "mt-5 rounded-2xl px-5 py-4 font-semibold border";

        if (type === "success") {
            box.classList.add("bg-green-500/10", "text-green-700", "border-green-400/20");
        } else {
            box.classList.add("bg-red-500/10", "text-red-700", "border-red-400/20");
        }

        box.textContent = message;
    }

    if (!publicKey) {
        showMessage("No se encontró la Public Key de Mercado Pago. Revise el archivo .env y config/services.php.", "error");
    } else {
        const mp = new MercadoPago(publicKey, {
            locale: "es-PE"
        });

        const bricksBuilder = mp.bricks();

        const renderPaymentBrick = async () => {
            try {
                const settings = {
                    initialization: {
                        amount: amount,
                        payer: {
                            email: userEmail,
                            entityType: "individual"
                        }
                    },

                    customization: {
                        paymentMethods: {
                            creditCard: "all",
                            debitCard: "all"
                        },
                        visual: {
                            style: {
                                theme: "default"
                            }
                        }
                    },

                    callbacks: {
                        onReady: () => {
                            console.log("Payment Brick cargado correctamente.");
                        },

                        onSubmit: ({ selectedPaymentMethod, formData }) => {
                            return new Promise((resolve, reject) => {
                                fetch("{{ route('client.payments.process', $serviceRequest) }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "Accept": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify(formData)
                                })
                                .then(response => response.json())
                                .then(response => {
                                    if (response.success) {
                                        showMessage(response.message, "success");

                                        setTimeout(() => {
                                            window.location.href = response.redirect_url;
                                        }, 1200);

                                        resolve();
                                    } else {
                                        showMessage(response.message, "error");
                                        reject();
                                    }
                                })
                                .catch(error => {
                                    console.error(error);
                                    showMessage("No se pudo procesar el pago.", "error");
                                    reject();
                                });
                            });
                        },

                        onError: (error) => {
                            console.error("Error Payment Brick:", error);
                            showMessage("Ocurrió un error al cargar el formulario de pago. Revise las credenciales de Mercado Pago.", "error");
                        }
                    }
                };

                await bricksBuilder.create(
                    "payment",
                    "paymentBrick_container",
                    settings
                );

            } catch (error) {
                console.error("Error al crear Payment Brick:", error);
                showMessage("No se pudo inicializar el formulario de pago.", "error");
            }
        };

        renderPaymentBrick();
    }
</script>

@endsection