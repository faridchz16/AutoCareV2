@extends('client.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Centro del cliente
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Detalle de la solicitud
        </h1>

        <p class="text-slate-300 mt-2">
            Revise el avance, pago y datos principales del mantenimiento solicitado.
        </p>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-1 rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Servicio
            </p>

            <h2 class="text-3xl font-extrabold text-white mt-3">
                {{ $serviceRequest->serviceType->name ?? 'Servicio no disponible' }}
            </h2>

            <div class="mt-6 space-y-4">
                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-slate-400">Estado del servicio</p>

                    <span class="inline-flex mt-3 rounded-full px-4 py-2 text-sm font-semibold border
                        @if($serviceRequest->status === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                        @elseif($serviceRequest->status === 'confirmado') bg-blue-500/10 text-blue-300 border-blue-400/20
                        @elseif($serviceRequest->status === 'en_taller') bg-sky-500/10 text-sky-300 border-sky-400/20
                        @elseif($serviceRequest->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                        @elseif($serviceRequest->status === 'finalizado_mecanico') bg-green-500/10 text-green-300 border-green-400/20
                        @elseif($serviceRequest->status === 'validado_administrador') bg-green-500/10 text-green-300 border-green-400/20
                        @elseif($serviceRequest->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                        @elseif($serviceRequest->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                        @else bg-slate-500/10 text-slate-300 border-slate-400/20
                        @endif">
                        {{ str_replace('_',' ',ucfirst($serviceRequest->status)) }}
                    </span>
                </div>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-slate-400">Estado del pago</p>

                    <span class="inline-flex mt-3 rounded-full px-4 py-2 text-sm font-semibold border
                        @if($serviceRequest->payment_status === 'pagado') bg-green-500/10 text-green-300 border-green-400/20
                        @elseif($serviceRequest->payment_status === 'validado') bg-green-500/10 text-green-300 border-green-400/20
                        @elseif($serviceRequest->payment_status === 'observado') bg-yellow-500/10 text-yellow-300 border-yellow-400/20
                        @elseif($serviceRequest->payment_status === 'reembolsado') bg-slate-500/10 text-slate-300 border-slate-400/20
                        @else bg-yellow-500/10 text-yellow-300 border-yellow-400/20
                        @endif">
                        {{ ucfirst($serviceRequest->payment_status ?? 'pendiente') }}
                    </span>
                </div>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-slate-400">Monto</p>

                    <p class="text-4xl font-extrabold text-cyan-300 mt-2">
                        S/. {{ number_format($serviceRequest->amount ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">
            <h2 class="text-2xl font-extrabold text-white mb-6">
                Información de la atención
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-cyan-400 font-bold">Vehículo</p>

                    <p class="text-white text-xl font-bold mt-2">
                        {{ $serviceRequest->vehicle_brand }} {{ $serviceRequest->vehicle_model }}
                    </p>

                    <p class="text-slate-400 mt-1">
                        Placa: {{ $serviceRequest->vehicle_plate }}
                    </p>
                </div>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-cyan-400 font-bold">Fecha programada</p>

                    @if($serviceRequest->serviceDate)
                        <p class="text-white text-xl font-bold mt-2">
                            {{ \Carbon\Carbon::parse($serviceRequest->serviceDate->available_date)->format('d/m/Y') }}
                        </p>

                        <p class="text-slate-400 mt-1">
                            {{ substr($serviceRequest->serviceDate->start_time,0,5) }}
                            -
                            {{ substr($serviceRequest->serviceDate->end_time,0,5) }}
                        </p>
                    @else
                        <p class="text-slate-300 mt-2">Fecha no disponible</p>
                    @endif
                </div>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-cyan-400 font-bold">Método de pago</p>

                    <p class="text-white text-xl font-bold mt-2">
                        {{ $serviceRequest->paymentMethod->name ?? 'No registrado' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5">
                    <p class="text-cyan-400 font-bold">Mecánico asignado</p>

                    <p class="text-white text-xl font-bold mt-2">
                        {{ $serviceRequest->mechanic->name ?? 'Aún no asignado' }}
                    </p>
                </div>

            </div>

            <div class="mt-8">
                <h3 class="text-xl font-bold text-white mb-3">
                    Observaciones del cliente
                </h3>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5 text-slate-300">
                    {{ $serviceRequest->customer_notes ?: 'No se registraron observaciones.' }}
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-bold text-white mb-3">
                    Observaciones del administrador
                </h3>

                <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-5 text-slate-300">
                    {{ $serviceRequest->admin_notes ?: 'Todavía no existen observaciones.' }}
                </div>
            </div>

            <div class="flex justify-end mt-10">
                <a href="{{ route('client.service-requests.index') }}"
                   class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-3 font-bold text-white hover:scale-105 transition">
                    Volver
                </a>
            </div>
        </div>

    </section>

</div>

@endsection