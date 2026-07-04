@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="relative overflow-hidden rounded-[32px] border border-cyan-400/20 bg-[#061a33] shadow-2xl">
        <div class="absolute inset-0 bg-cover bg-center opacity-60"
             style="background-image: url('{{ asset('images/autocare/admin-bg.png') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-[#031020] via-[#061a33]/95 to-[#061a33]/50"></div>

        <div class="relative px-10 py-12">
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                AutoCare - Panel Administrativo
            </p>

            <h1 class="mt-4 text-5xl font-extrabold text-white">
                {{ $greeting }}, {{ auth()->user()->name }}
            </h1>

            <p class="mt-4 max-w-3xl text-lg text-slate-300">
                Bienvenido al panel administrativo de AutoCare. Desde este espacio podrá supervisar las operaciones del sistema y dar seguimiento a los servicios registrados.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('admin.services.index') }}"
                   class="flex items-center gap-3 rounded-2xl bg-[#2563eb] px-6 py-4 font-bold text-white hover:bg-[#1d4ed8] transition shadow-lg">
                    <x-admin.icon-tool />
                    Servicios
                </a>

                <a href="{{ route('admin.service-dates.index') }}"
                   class="flex items-center gap-3 rounded-2xl bg-[#06b6d4] px-6 py-4 font-bold text-white hover:bg-[#0891b2] transition shadow-lg">
                    <x-admin.icon-calendar />
                    Fechas disponibles
                </a>

                <a href="{{ route('admin.vehicle-types.index') }}"
                   class="flex items-center gap-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-4 font-bold text-white hover:from-cyan-600 hover:to-blue-700 transition shadow-lg">
                    <span class="w-6 h-6 text-xl flex items-center justify-center">▣</span>
                    Tipos de vehículos
                </a>

                <a href="{{ route('admin.workshops.index') }}"
                   class="flex items-center gap-3 rounded-2xl bg-[#0284c7] px-6 py-4 font-bold text-white hover:bg-[#0369a1] transition shadow-lg">
                    <span class="w-6 h-6 text-xl flex items-center justify-center">⌂</span>
                    Sedes / Talleres
                </a>

                <a href="{{ route('admin.service-requests.index') }}"
                   class="flex items-center gap-3 rounded-2xl bg-[#0f766e] px-6 py-4 font-bold text-white hover:bg-[#115e59] transition shadow-lg">
                    <x-admin.icon-clipboard />
                    Solicitudes
                </a>
            </div>
        </div>
    </section>

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
        <div class="mb-6">
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Resumen del día
            </p>

            <h2 class="text-3xl font-extrabold text-white mt-2">
                Estado general de AutoCare
            </h2>

            <p class="text-slate-300 mt-1">
                Vista rápida de los servicios, solicitudes y disponibilidad actual del sistema.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <div class="rounded-3xl bg-[#082344]/90 border border-blue-400/20 p-6 hover:-translate-y-1 transition shadow-lg">
                <p class="text-slate-300">Solicitudes totales</p>
                <h3 class="text-5xl font-extrabold text-blue-300 mt-3">{{ $totalRequests }}</h3>
                <p class="text-blue-300 mt-3">Atenciones registradas</p>
            </div>

            <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/20 p-6 hover:-translate-y-1 transition shadow-lg">
                <p class="text-slate-300">Pendientes</p>
                <h3 class="text-5xl font-extrabold text-cyan-300 mt-3">{{ $pendingRequests }}</h3>
                <p class="text-cyan-300 mt-3">Solicitudes por revisar</p>
            </div>

            <div class="rounded-3xl bg-[#082344]/90 border border-sky-400/20 p-6 hover:-translate-y-1 transition shadow-lg">
                <p class="text-slate-300">En proceso</p>
                <h3 class="text-5xl font-extrabold text-sky-300 mt-3">{{ $processRequests }}</h3>
                <p class="text-sky-300 mt-3">Servicios en atención</p>
            </div>

            <div class="rounded-3xl bg-[#082344]/90 border border-teal-400/20 p-6 hover:-translate-y-1 transition shadow-lg">
                <p class="text-slate-300">Terminadas</p>
                <h3 class="text-5xl font-extrabold text-teal-300 mt-3">{{ $readyRequests }}</h3>
                <p class="text-teal-300 mt-3">Servicios listos</p>
            </div>

        </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center mb-5 shadow-lg shadow-blue-900/40">
                <x-admin.icon-tool />
            </div>

            <p class="text-slate-300">Servicios registrados</p>
            <h2 class="mt-2 text-5xl font-extrabold text-white">{{ $totalServices }}</h2>
            <p class="mt-2 text-cyan-300">{{ $activeServices }} activos</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-cyan-700 flex items-center justify-center mb-5 shadow-lg shadow-cyan-900/40">
                <x-admin.icon-calendar />
            </div>

            <p class="text-slate-300">Fechas disponibles</p>
            <h2 class="mt-2 text-5xl font-extrabold text-white">{{ $availableDates }}</h2>
            <p class="mt-2 text-cyan-300">{{ $blockedDates }} bloqueadas</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-800 flex items-center justify-center mb-5 shadow-lg shadow-sky-900/40">
                <span class="text-2xl">⌂</span>
            </div>

            <p class="text-slate-300">Sedes registradas</p>
            <h2 class="mt-2 text-5xl font-extrabold text-white">{{ $totalWorkshops ?? 0 }}</h2>
            <p class="mt-2 text-cyan-300">{{ $activeWorkshops ?? 0 }} activas</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl hover:-translate-y-1 transition">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-800 flex items-center justify-center mb-5 shadow-lg shadow-teal-900/40">
                <x-admin.icon-user />
            </div>

            <p class="text-slate-300">Mecánicos activos</p>
            <h2 class="mt-2 text-5xl font-extrabold text-white">{{ $activeMechanics }}</h2>
            <p class="mt-2 text-cyan-300">Personal disponible</p>
        </div>

    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-white">Últimas solicitudes</h2>
                    <p class="text-slate-300 mt-1">Solicitudes recientes registradas por los clientes.</p>
                </div>

                <a href="{{ route('admin.service-requests.index') }}"
                   class="rounded-2xl bg-cyan-500/10 px-5 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                    Ver todo
                </a>
            </div>

            <div class="space-y-4">
                @forelse($latestRequests as $request)
                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-white font-bold">
                                {{ $request->customer->name ?? 'Cliente no disponible' }}
                            </p>

                            <p class="text-slate-300 text-sm mt-1">
                                {{ $request->serviceType->name ?? 'Servicio no disponible' }}
                            </p>

                            <p class="text-slate-400 text-sm mt-1">
                                {{ $request->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                @if($request->status === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                @elseif($request->status === 'en_proceso') bg-sky-500/10 text-sky-300 border-sky-400/20
                                @elseif($request->status === 'listo') bg-teal-500/10 text-teal-300 border-teal-400/20
                                @elseif($request->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                @endif">
                                {{ str_replace('_', ' ', ucfirst($request->status)) }}
                            </span>

                            <a href="{{ route('admin.service-requests.show', $request) }}"
                               class="text-cyan-300 font-bold hover:text-white transition">
                                Gestionar →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-6 text-slate-300">
                        Aún no existen solicitudes recientes.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <h2 class="text-3xl font-extrabold text-white">Actividad reciente</h2>
            <p class="text-slate-300 mt-1 mb-6">Últimos movimientos del sistema.</p>

            <div class="space-y-5">
                @forelse($latestServices as $service)
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-300 flex items-center justify-center">
                            <x-admin.icon-tool />
                        </div>

                        <div>
                            <p class="text-white font-semibold">
                                Servicio agregado
                            </p>
                            <p class="text-slate-300 text-sm">
                                {{ $service->name }}
                            </p>
                            <p class="text-slate-500 text-xs mt-1">
                                {{ $service->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-300">Aún no hay actividad registrada.</p>
                @endforelse
            </div>
        </div>

    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <h2 class="text-2xl font-extrabold text-white mb-5">Últimos servicios</h2>

            <div class="space-y-4">
                @forelse($latestServices as $service)
                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-4">
                        <p class="text-white font-bold">{{ $service->name }}</p>
                        <p class="text-slate-400 text-sm mt-1">
                            {{ $service->estimated_minutes }} min
                        </p>
                    </div>
                @empty
                    <p class="text-slate-300">No hay servicios registrados.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <h2 class="text-2xl font-extrabold text-white mb-5">Próximas fechas</h2>

            <div class="space-y-4">
                @forelse($latestDates as $date)
                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-4">
                        <p class="text-white font-bold">
                            {{ $date->serviceType->name ?? 'Servicio no disponible' }}
                        </p>
                        <p class="text-slate-400 text-sm mt-1">
                            {{ \Carbon\Carbon::parse($date->available_date)->format('d/m/Y') }}
                            · {{ substr($date->start_time, 0, 5) }} - {{ substr($date->end_time, 0, 5) }}
                        </p>
                    </div>
                @empty
                    <p class="text-slate-300">No hay fechas registradas.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">
            <h2 class="text-2xl font-extrabold text-white mb-5">Sedes / Talleres</h2>

            <div class="space-y-4">
                @forelse(($latestWorkshops ?? collect()) as $workshop)
                    <div class="rounded-2xl bg-[#082344]/90 border border-cyan-400/10 p-4">
                        <p class="text-white font-bold">{{ $workshop->name }}</p>
                        <p class="text-slate-400 text-sm mt-1">
                            {{ $workshop->address }}
                        </p>

                        @if($workshop->status === 'activo')
                            <p class="text-cyan-300 text-sm mt-1">Activa</p>
                        @else
                            <p class="text-red-300 text-sm mt-1">Inactiva</p>
                        @endif
                    </div>
                @empty
                    <p class="text-slate-300">No hay sedes o talleres registrados.</p>
                @endforelse
            </div>
        </div>

    </section>

</div>

@endsection