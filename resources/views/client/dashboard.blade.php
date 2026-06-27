@extends('client.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="relative overflow-hidden rounded-[32px] border border-cyan-400/20 bg-[#061a33] shadow-2xl">
        <div class="absolute inset-0 bg-cover bg-center opacity-60"
             style="background-image:url('{{ asset('images/autocare/admin-bg.png') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-[#031020] via-[#061a33]/95 to-[#061a33]/50"></div>

        <div class="relative px-10 py-12">
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                AutoCare · Panel del Cliente
            </p>

            <h1 class="mt-4 text-5xl font-extrabold text-white">
                Bienvenido, {{ auth()->user()->name }}
            </h1>

            <p class="mt-4 max-w-3xl text-lg text-slate-300">
                Gestiona el mantenimiento de tu vehículo, revisa tus solicitudes y da seguimiento a cada atención registrada en AutoCare.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('client.service-requests.create') }}"
                   class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-7 py-4 font-bold text-white hover:scale-105 transition">
                    Solicitar mantenimiento
                </a>

                <a href="{{ route('client.service-requests.index') }}"
                   class="rounded-2xl bg-cyan-500/10 border border-cyan-400/20 px-7 py-4 font-bold text-cyan-300 hover:bg-cyan-500 hover:text-white transition">
                    Mis solicitudes
                </a>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Vehículos registrados</p>
            <h2 class="mt-2 text-5xl font-extrabold text-white">{{ $totalVehicles }}</h2>
            <p class="mt-2 text-cyan-300">Vehículos activos</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Solicitudes activas</p>
            <h2 class="mt-2 text-5xl font-extrabold text-white">{{ $activeRequests }}</h2>
            <p class="mt-2 text-cyan-300">En seguimiento</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Próxima cita</p>

            <h2 class="mt-2 text-3xl font-extrabold text-white">
                @if($nextRequest && $nextRequest->serviceDate)
                    {{ \Carbon\Carbon::parse($nextRequest->serviceDate->available_date)->format('d/m') }}
                @else
                    --
                @endif
            </h2>

            <p class="mt-2 text-cyan-300">
                @if($nextRequest && $nextRequest->serviceDate)
                    {{ substr($nextRequest->serviceDate->start_time, 0, 5) }}
                @else
                    Sin cita programada
                @endif
            </p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Pagos pendientes</p>
            <h2 class="mt-2 text-5xl font-extrabold text-white">{{ $pendingPayments }}</h2>
            <p class="mt-2 text-cyan-300">Por validar</p>
        </div>

    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-white">
                        Mis solicitudes recientes
                    </h2>

                    <p class="text-slate-300 mt-2">
                        Últimos servicios solicitados por usted.
                    </p>
                </div>

                <a href="{{ route('client.service-requests.index') }}"
                   class="rounded-2xl bg-cyan-500/10 border border-cyan-400/20 px-5 py-3 font-bold text-cyan-300 hover:bg-cyan-500 hover:text-white transition">
                    Ver todo
                </a>
            </div>

            <div class="space-y-4">
                @forelse($latestRequests as $request)
                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <p class="text-white font-bold">
                                {{ $request->serviceType->name ?? 'Servicio no disponible' }}
                            </p>

                            <p class="text-slate-300 text-sm mt-1">
                                {{ $request->vehicle_brand }} {{ $request->vehicle_model }} · {{ $request->vehicle_plate }}
                            </p>

                            <p class="text-slate-400 text-sm mt-1">
                                @if($request->serviceDate)
                                    {{ \Carbon\Carbon::parse($request->serviceDate->available_date)->format('d/m/Y') }}
                                    · {{ substr($request->serviceDate->start_time, 0, 5) }}
                                @else
                                    Fecha no disponible
                                @endif
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                @if($request->status === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                @elseif($request->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                                @elseif($request->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                                @elseif($request->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                @endif">
                                {{ str_replace('_', ' ', ucfirst($request->status)) }}
                            </span>

                            <a href="{{ route('client.service-requests.show', $request) }}"
                               class="text-cyan-300 font-bold hover:text-white transition">
                                Ver →
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-cyan-400/20 py-16 text-center">
                        <p class="text-slate-400">
                            Aún no existen solicitudes registradas.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <h2 class="text-3xl font-extrabold text-white">
                Estado actual
            </h2>

            <p class="text-slate-300 mt-2">
                Última atención registrada.
            </p>

            @if($lastRequest)
                <div class="mt-8 space-y-5">
                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-5">
                        <p class="text-cyan-300 font-semibold">Servicio</p>
                        <p class="text-white font-bold mt-2">
                            {{ $lastRequest->serviceType->name ?? 'Servicio no disponible' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-5">
                        <p class="text-cyan-300 font-semibold">Vehículo</p>
                        <p class="text-white font-bold mt-2">
                            {{ $lastRequest->vehicle_brand }} {{ $lastRequest->vehicle_model }}
                        </p>
                        <p class="text-slate-400 text-sm mt-1">
                            Placa: {{ $lastRequest->vehicle_plate }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-5">
                        <p class="text-cyan-300 font-semibold">Estado</p>
                        <p class="text-white font-bold mt-2">
                            {{ str_replace('_', ' ', ucfirst($lastRequest->status)) }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-5">
                        <p class="text-cyan-300 font-semibold">Mecánico</p>
                        <p class="text-white font-bold mt-2">
                            {{ $lastRequest->mechanic->name ?? 'Aún no asignado' }}
                        </p>
                    </div>
                </div>
            @else
                <div class="mt-8 rounded-3xl border border-dashed border-cyan-400/20 py-16 text-center">
                    <p class="text-slate-400">
                        Aún no tiene mantenimientos registrados.
                    </p>
                </div>
            @endif
        </div>

    </section>

</div>

@endsection