@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Módulo administrativo
            </p>

            <div class="flex items-center gap-4 mt-2">
                <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                    <x-admin.icon-calendar />
                </div>

                <h1 class="text-4xl font-extrabold text-white">
                    Fechas disponibles
                </h1>
            </div>

            <p class="text-slate-300 mt-3">
                Habilite o deshabilite fechas para que los clientes puedan registrar una atención.
            </p>
        </div>

        <a href="{{ route('admin.service-dates.create') }}"
           class="inline-flex items-center gap-3 justify-center rounded-2xl bg-cyan-500 px-6 py-4 text-white font-bold hover:bg-cyan-600 transition">
            <x-admin.icon-plus />
            Registrar fecha
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 px-5 py-4 text-green-300 border border-green-400/20">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 px-5 py-4 text-red-300 border border-red-400/20">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Total fechas</p>
                <div class="w-11 h-11 rounded-xl bg-white/5 flex items-center justify-center text-cyan-300">
                    <x-admin.icon-calendar />
                </div>
            </div>
            <h2 class="text-5xl font-extrabold text-white mt-3">{{ $totalDates }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Disponibles</p>
                <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
            </div>
            <h2 class="text-5xl font-extrabold text-cyan-300 mt-3">{{ $availableDates }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Reservadas</p>
                <span class="w-3 h-3 rounded-full bg-blue-400"></span>
            </div>
            <h2 class="text-5xl font-extrabold text-blue-300 mt-3">{{ $reservedDates }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Bloqueadas</p>
                <span class="w-3 h-3 rounded-full bg-red-400"></span>
            </div>
            <h2 class="text-5xl font-extrabold text-red-300 mt-3">{{ $blockedDates }}</h2>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.service-dates.index') }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl flex flex-col lg:flex-row gap-4">

        <div class="relative flex-1">
            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-cyan-300">
                <x-admin.icon-search />
            </div>

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Buscar por servicio..."
                   class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 pl-14 pr-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

        <select name="status"
                class="rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">
            <option value="">Todos los estados</option>
            <option value="disponible" @selected(request('status') === 'disponible')>Disponible</option>
            <option value="reservado" @selected(request('status') === 'reservado')>Reservado</option>
            <option value="no_disponible" @selected(request('status') === 'no_disponible')>No disponible</option>
            <option value="cancelado" @selected(request('status') === 'cancelado')>Cancelado</option>
        </select>

        <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
            <x-admin.icon-search />
            Buscar
        </button>

        <a href="{{ route('admin.service-dates.index') }}"
           class="rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
            Limpiar
        </a>
    </form>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-cyan-400/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-calendar />
            </div>

            <div>
                <h2 class="text-xl font-bold text-white">
                    Calendario de atención
                </h2>
                <p class="text-sm text-slate-300 mt-1">
                    Fechas, horarios y disponibilidad registrados para los servicios.
                </p>
            </div>
        </div>

        <div class="p-6 space-y-5">

            @forelse($dates as $date)

                <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 hover:-translate-y-1 hover:border-cyan-400/30 hover:shadow-xl hover:shadow-cyan-900/20 transition">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex flex-col items-center justify-center text-cyan-300 shrink-0">
                                <span class="text-2xl font-extrabold">
                                    {{ \Carbon\Carbon::parse($date->available_date)->format('d') }}
                                </span>
                                <span class="text-xs uppercase">
                                    {{ \Carbon\Carbon::parse($date->available_date)->locale('es')->translatedFormat('M') }}
                                </span>
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-extrabold text-white">
                                        {{ $date->serviceType->name ?? 'Servicio no disponible' }}
                                    </h3>

                                    @if($date->status === 'disponible')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-cyan-500/10 px-4 py-1.5 text-sm font-semibold text-cyan-300 border border-cyan-400/20">
                                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                            Disponible
                                        </span>
                                    @elseif($date->status === 'reservado')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-blue-500/10 px-4 py-1.5 text-sm font-semibold text-blue-300 border border-blue-400/20">
                                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                            Reservado
                                        </span>
                                    @elseif($date->status === 'no_disponible')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-red-500/10 px-4 py-1.5 text-sm font-semibold text-red-300 border border-red-400/20">
                                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                            No disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-500/10 px-4 py-1.5 text-sm font-semibold text-slate-300 border border-slate-400/20">
                                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                            Cancelado
                                        </span>
                                    @endif
                                </div>

                                <p class="text-slate-300 mt-2">
                                    Atención programada para el
                                    {{ \Carbon\Carbon::parse($date->available_date)->locale('es')->translatedFormat('d \d\e F \d\e Y') }}.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 xl:w-[260px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Horario
                                </p>

                                <div class="mt-2 flex items-center gap-2 text-white font-semibold">
                                    <span class="text-cyan-300">
                                        <x-admin.icon-clock />
                                    </span>
                                    {{ substr($date->start_time, 0, 5) }} - {{ substr($date->end_time, 0, 5) }}
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row xl:flex-col gap-3 xl:w-32">

                            <a href="{{ route('admin.service-dates.show', $date) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 px-4 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                <x-admin.icon-eye />
                                Ver
                            </a>

                            <a href="{{ route('admin.service-dates.edit', $date) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-500/10 px-4 py-3 text-blue-300 font-bold border border-blue-400/20 hover:bg-blue-600 hover:text-white transition">
                                <x-admin.icon-edit />
                                Editar
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-14 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 mb-4">
                        <x-admin.icon-calendar />
                    </div>

                    <p class="text-white font-bold text-lg">
                        No hay fechas de atención registradas
                    </p>

                    <p class="text-slate-300 mt-1">
                        Registre fechas para que los clientes puedan solicitar sus servicios.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-4 text-white border-t border-cyan-400/10">
            {{ $dates->links() }}
        </div>
    </div>

</div>

@endsection