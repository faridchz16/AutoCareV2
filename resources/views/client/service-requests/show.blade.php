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
            Revise toda la información de su solicitud de mantenimiento.
        </p>

    </section>

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>
                <p class="text-cyan-400 font-semibold">Vehículo</p>
                <p class="text-2xl font-bold text-white mt-2">
                    {{ $serviceRequest->vehicle_brand }}
                    {{ $serviceRequest->vehicle_model }}
                </p>

                <p class="text-slate-300 mt-1">
                    Placa:
                    {{ $serviceRequest->vehicle_plate }}
                </p>
            </div>

            <div>
                <p class="text-cyan-400 font-semibold">
                    Servicio solicitado
                </p>

                <p class="text-2xl font-bold text-white mt-2">
                    {{ $serviceRequest->serviceType->name }}
                </p>
            </div>

            <div>
                <p class="text-cyan-400 font-semibold">
                    Fecha programada
                </p>

                <p class="text-white mt-2">
                    {{ \Carbon\Carbon::parse($serviceRequest->serviceDate->available_date)->format('d/m/Y') }}
                </p>

                <p class="text-slate-300">
                    {{ substr($serviceRequest->serviceDate->start_time,0,5) }}
                    -
                    {{ substr($serviceRequest->serviceDate->end_time,0,5) }}
                </p>
            </div>

            <div>
                <p class="text-cyan-400 font-semibold">
                    Método de pago
                </p>

                <p class="text-white mt-2">
                    {{ $serviceRequest->paymentMethod->name }}
                </p>
            </div>

            <div>
                <p class="text-cyan-400 font-semibold">
                    Mecánico asignado
                </p>

                <p class="text-white mt-2">
                    {{ $serviceRequest->mechanic->name ?? 'Aún no asignado' }}
                </p>
            </div>

            <div>
                <p class="text-cyan-400 font-semibold">
                    Estado del servicio
                </p>

                <span class="inline-flex mt-2 rounded-full bg-cyan-500/10 border border-cyan-400/20 px-4 py-2 text-cyan-300">
                    {{ str_replace('_',' ',ucfirst($serviceRequest->status)) }}
                </span>
            </div>

        </div>

        <div class="mt-10">

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

    </section>

</div>

@endsection