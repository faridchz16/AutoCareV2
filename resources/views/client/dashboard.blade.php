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
                Gestione sus vehículos, solicite mantenimientos y revise el avance de sus atenciones registradas.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('client.service-requests.create') }}"
                   class="inline-flex items-center gap-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-7 py-4 font-bold text-white hover:scale-105 transition">
                    <x-admin.icon-tool />
                    Solicitar mantenimiento
                </a>

                <a href="{{ route('client.service-requests.index') }}"
                   class="inline-flex items-center gap-3 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 px-7 py-4 font-bold text-cyan-300 hover:bg-cyan-500 hover:text-white transition">
                    <x-admin.icon-clipboard />
                    Mis solicitudes
                </a>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Vehículos registrados</p>
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                    <x-admin.icon-dashboard />
                </div>
            </div>

            <h2 class="mt-3 text-5xl font-extrabold text-white">{{ $totalVehicles }}</h2>
            <p class="mt-2 text-cyan-300">Vehículos activos</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Solicitudes activas</p>
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-blue-300">
                    <x-admin.icon-clipboard />
                </div>
            </div>

            <h2 class="mt-3 text-5xl font-extrabold text-white">{{ $activeRequests }}</h2>
            <p class="mt-2 text-cyan-300">En seguimiento</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Próxima cita</p>
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                    <x-admin.icon-calendar />
                </div>
            </div>

            <h2 class="mt-3 text-4xl font-extrabold text-white">
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

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Pagos pendientes</p>
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center text-blue-300">
                    <x-admin.icon-card />
                </div>
            </div>

            <h2 class="mt-3 text-5xl font-extrabold text-white">{{ $pendingPayments }}</h2>
            <p class="mt-2 text-cyan-300">Por completar o validar</p>
        </div>

    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                            <x-admin.icon-clipboard />
                        </div>

                        <h2 class="text-3xl font-extrabold text-white">
                            Mis solicitudes recientes
                        </h2>
                    </div>

                    <p class="text-slate-300 mt-2">
                        Últimos servicios solicitados por usted.
                    </p>
                </div>

                <a href="{{ route('client.service-requests.index') }}"
                   class="inline-flex items-center gap-2 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 px-5 py-3 font-bold text-cyan-300 hover:bg-cyan-500 hover:text-white transition">
                    <x-admin.icon-eye />
                    Ver todo
                </a>
            </div>

            <div class="space-y-4">
                @forelse($latestRequests as $request)

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-5 hover:-translate-y-1 hover:border-cyan-400/30 transition">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 shrink-0">
                                    <x-admin.icon-tool />
                                </div>

                                <div>
                                    <p class="text-white font-bold text-lg">
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
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                    @if($request->status === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @elseif($request->status === 'confirmado') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->status === 'en_taller') bg-sky-500/10 text-sky-300 border-sky-400/20
                                    @elseif($request->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->status === 'finalizado_mecanico') bg-teal-500/10 text-teal-300 border-teal-400/20
                                    @elseif($request->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($request->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                    @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                </span>

                                <a href="{{ route('client.service-requests.show', $request) }}"
                                   class="inline-flex items-center gap-2 text-cyan-300 font-bold hover:text-white transition">
                                    Ver
                                    <span>→</span>
                                </a>
                            </div>

                        </div>

                    </div>

                @empty
                    <div class="rounded-3xl border border-dashed border-cyan-400/20 py-16 text-center">
                        <div class="mx-auto w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 mb-4">
                            <x-admin.icon-clipboard />
                        </div>

                        <p class="text-white font-bold">
                            Aún no existen solicitudes registradas.
                        </p>

                        <p class="text-slate-400 mt-1">
                            Solicite un mantenimiento para comenzar el seguimiento.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                    <x-admin.icon-dashboard />
                </div>

                <div>
                    <h2 class="text-3xl font-extrabold text-white">
                        Estado actual
                    </h2>

                    <p class="text-slate-300 mt-1">
                        Última atención registrada.
                    </p>
                </div>
            </div>

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

                        <span class="inline-flex mt-2 rounded-full px-3 py-1 text-sm font-semibold border
                            @if($lastRequest->status === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                            @elseif($lastRequest->status === 'confirmado') bg-blue-500/10 text-blue-300 border-blue-400/20
                            @elseif($lastRequest->status === 'en_taller') bg-sky-500/10 text-sky-300 border-sky-400/20
                            @elseif($lastRequest->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                            @elseif($lastRequest->status === 'finalizado_mecanico') bg-teal-500/10 text-teal-300 border-teal-400/20
                            @elseif($lastRequest->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                            @elseif($lastRequest->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                            @else bg-slate-500/10 text-slate-300 border-slate-400/20
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($lastRequest->status)) }}
                        </span>
                    </div>

                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-5">
                        <p class="text-cyan-300 font-semibold">Mecánico</p>
                        <p class="text-white font-bold mt-2">
                            {{ $lastRequest->mechanic->name ?? 'Aún no asignado' }}
                        </p>
                    </div>

                    @if($lastRequest->serviceDate)
                        <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-5">
                            <p class="text-cyan-300 font-semibold">Fecha de atención</p>
                            <p class="text-white font-bold mt-2">
                                {{ \Carbon\Carbon::parse($lastRequest->serviceDate->available_date)->format('d/m/Y') }}
                                · {{ substr($lastRequest->serviceDate->start_time, 0, 5) }}
                            </p>
                        </div>
                    @endif

                    <a href="{{ route('client.service-requests.show', $lastRequest) }}"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 px-5 py-3 text-cyan-300 font-bold hover:bg-cyan-500 hover:text-white transition">
                        <x-admin.icon-eye />
                        Ver detalle completo
                    </a>

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