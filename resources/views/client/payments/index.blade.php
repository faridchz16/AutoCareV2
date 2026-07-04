@extends('client.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <div>
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Centro del cliente
            </p>

            <div class="flex items-center gap-4 mt-2">
                <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                    <x-admin.icon-card />
                </div>

                <h1 class="text-4xl font-extrabold text-white">
                    Mis pagos
                </h1>
            </div>

            <p class="text-slate-300 mt-3">
                Consulte los pagos registrados y complete los pagos pendientes desde AutoCare.
            </p>
        </div>
    </section>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 border border-green-400/20 text-green-300 px-6 py-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 border border-red-400/20 text-red-300 px-6 py-4">
            {{ session('error') }}
        </div>
    @endif

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-8 py-5 border-b border-cyan-400/10 flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-card />
            </div>

            <div>
                <h2 class="text-2xl font-bold text-white">
                    Pagos registrados
                </h2>

                <p class="text-slate-300 mt-1">
                    Seleccione una solicitud pendiente para completar el pago.
                </p>
            </div>
        </div>

        <div class="p-6 space-y-5">

            @forelse($payments as $payment)

                <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 hover:-translate-y-1 hover:border-cyan-400/30 hover:shadow-xl hover:shadow-cyan-900/20 transition">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 shrink-0">
                                <x-admin.icon-card />
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-extrabold text-white">
                                        {{ $payment->serviceType->name ?? 'Servicio no disponible' }}
                                    </h3>

                                    @if($payment->payment_status == 'pagado')
                                        <span class="inline-flex rounded-full bg-green-500/10 border border-green-400/20 px-4 py-1.5 text-green-300 text-sm font-semibold">
                                            Pagado
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-yellow-500/10 border border-yellow-400/20 px-4 py-1.5 text-yellow-300 text-sm font-semibold">
                                            Pendiente
                                        </span>
                                    @endif
                                </div>

                                <p class="text-slate-300 mt-2">
                                    Método:
                                    <span class="text-white font-semibold">
                                        {{ $payment->paymentMethod->name ?? 'No registrado' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 xl:w-[520px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Monto
                                </p>

                                <p class="text-2xl font-extrabold text-white mt-2">
                                    S/. {{ number_format($payment->amount, 2) }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Estado
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ ucfirst($payment->payment_status ?? 'pendiente') }}
                                </p>
                            </div>

                        </div>

                        <div class="xl:w-44">

                            @if($payment->payment_status == 'pendiente')

                                <a href="{{ route('client.payments.checkout',$payment) }}"
                                   class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 font-bold text-white hover:scale-105 transition">
                                    <x-admin.icon-card />
                                    Pagar ahora
                                </a>

                            @else

                                <div class="w-full inline-flex items-center justify-center rounded-2xl bg-green-500/10 border border-green-400/20 px-5 py-3 text-green-300 font-bold">
                                    Completado
                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-16 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 mb-4">
                        <x-admin.icon-card />
                    </div>

                    <p class="text-white font-bold text-lg">
                        No tiene pagos registrados
                    </p>

                    <p class="text-slate-300 mt-1">
                        Cuando solicite un mantenimiento, los pagos aparecerán en esta sección.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-5 border-t border-cyan-400/10">
            {{ $payments->links() }}
        </div>

    </section>

</div>

@endsection