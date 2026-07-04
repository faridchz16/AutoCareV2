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
                    <span class="text-2xl">▣</span>
                </div>

                <h1 class="text-4xl font-extrabold text-white">
                    Gestión de tipos de vehículos
                </h1>
            </div>

            <p class="text-slate-300 mt-3">
                Administre los tipos de vehículos disponibles para los clientes.
            </p>
        </div>

        <a href="{{ route('admin.vehicle-types.create') }}"
           class="inline-flex items-center gap-3 justify-center rounded-2xl bg-cyan-500 px-6 py-4 text-white font-bold hover:bg-cyan-600 transition">
            <x-admin.icon-plus />
            Nuevo tipo
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Total registrados</p>
                <div class="w-11 h-11 rounded-xl bg-white/5 flex items-center justify-center text-cyan-300">
                    <span class="text-xl">▣</span>
                </div>
            </div>

            <h2 class="text-5xl font-extrabold text-white mt-3">
                {{ $totalVehicleTypes }}
            </h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Activos</p>
                <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
            </div>

            <h2 class="text-5xl font-extrabold text-cyan-300 mt-3">
                {{ $activeVehicleTypes }}
            </h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Inactivos</p>
                <span class="w-3 h-3 rounded-full bg-red-400"></span>
            </div>

            <h2 class="text-5xl font-extrabold text-red-300 mt-3">
                {{ $inactiveVehicleTypes }}
            </h2>
        </div>

    </div>

    <form method="GET"
          action="{{ route('admin.vehicle-types.index') }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl flex flex-col md:flex-row gap-4">

        <div class="relative flex-1">
            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-cyan-300">
                <x-admin.icon-search />
            </div>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar tipo de vehículo..."
                class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 pl-14 pr-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

        <select
            name="status"
            class="rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

            <option value="">Todos los estados</option>
            <option value="activo" @selected(request('status') == 'activo')>Activos</option>
            <option value="inactivo" @selected(request('status') == 'inactivo')>Inactivos</option>

        </select>

        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
            <x-admin.icon-search />
            Buscar
        </button>

        <a href="{{ route('admin.vehicle-types.index') }}"
           class="rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
            Limpiar
        </a>

    </form>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-6 py-5 border-b border-cyan-400/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <span class="text-xl">▣</span>
            </div>

            <h2 class="text-xl font-bold text-white">
                Tipos de vehículos registrados
            </h2>
        </div>

        <div class="divide-y divide-cyan-400/10">

            @forelse($vehicleTypes as $vehicleType)

                <div class="px-6 py-6 hover:bg-white/5 hover:-translate-y-0.5 transition-all">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 shrink-0">
                                <span class="text-xl">▣</span>
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-lg font-extrabold text-white">
                                        {{ $vehicleType->name }}
                                    </h3>

                                    @if($vehicleType->status == 'activo')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-cyan-500/10 px-3 py-1 text-sm font-semibold text-cyan-300 border border-cyan-400/20">
                                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-red-500/10 px-3 py-1 text-sm font-semibold text-red-300 border border-red-400/20">
                                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                            Inactivo
                                        </span>
                                    @endif
                                </div>

                                <p class="text-slate-300 mt-2 max-w-4xl">
                                    {{ $vehicleType->description ?: 'Sin descripción registrada.' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">

                            <a href="{{ route('admin.vehicle-types.show', $vehicleType) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 px-4 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                <x-admin.icon-eye />
                                Ver
                            </a>

                            <a href="{{ route('admin.vehicle-types.edit', $vehicleType) }}"
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
                        <span class="text-2xl">▣</span>
                    </div>

                    <p class="text-white font-bold text-lg">
                        No hay tipos de vehículos registrados
                    </p>

                    <p class="text-slate-300 mt-1">
                        Registre un tipo de vehículo para organizar mejor los servicios del sistema.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-4 text-white border-t border-cyan-400/10">
            {{ $vehicleTypes->links() }}
        </div>

    </div>

</div>

@endsection