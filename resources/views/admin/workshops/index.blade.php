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
                    <x-admin.icon-workshop />
                </div>

                <h1 class="text-4xl font-extrabold text-white">
                    Gestión de sedes y talleres
                </h1>
            </div>

            <p class="text-slate-300 mt-3">
                Administre las sedes o talleres disponibles para la atención de servicios vehiculares.
            </p>
        </div>

        <a href="{{ route('admin.workshops.create') }}"
           class="inline-flex items-center gap-3 justify-center rounded-2xl bg-cyan-500 px-6 py-4 text-white font-bold hover:bg-cyan-600 transition">
            <x-admin.icon-workshop />
            Nueva sede
        </a>

    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 px-5 py-4 text-green-300 border border-green-400/20">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Total registradas</p>
                <div class="w-11 h-11 rounded-xl bg-white/5 flex items-center justify-center text-cyan-300">
                    <x-admin.icon-workshop />
                </div>
            </div>

            <h2 class="text-5xl font-extrabold text-white mt-3">
                {{ $totalWorkshops }}
            </h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Activas</p>
                <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
            </div>

            <h2 class="text-5xl font-extrabold text-cyan-300 mt-3">
                {{ $activeWorkshops }}
            </h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <p class="text-slate-300">Inactivas</p>
                <span class="w-3 h-3 rounded-full bg-red-400"></span>
            </div>

            <h2 class="text-5xl font-extrabold text-red-300 mt-3">
                {{ $inactiveWorkshops }}
            </h2>
        </div>

    </div>

    <form method="GET"
          action="{{ route('admin.workshops.index') }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl flex flex-col md:flex-row gap-4">

        <div class="relative flex-1">
            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-cyan-300">
                <x-admin.icon-search />
            </div>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar sede, dirección o teléfono..."
                class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 pl-14 pr-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

        <select
            name="status"
            class="rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

            <option value="">Todos los estados</option>
            <option value="activo" @selected(request('status') == 'activo')>Activas</option>
            <option value="inactivo" @selected(request('status') == 'inactivo')>Inactivas</option>

        </select>

        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
            <x-admin.icon-search />
            Buscar
        </button>

        <a href="{{ route('admin.workshops.index') }}"
           class="rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
            Limpiar
        </a>

    </form>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-6 py-5 border-b border-cyan-400/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-workshop />
            </div>

            <h2 class="text-xl font-bold text-white">
                Sedes y talleres registrados
            </h2>
        </div>

        <div class="p-6">

            @forelse($workshops as $workshop)

                <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 mb-5 hover:-translate-y-1 hover:border-cyan-400/30 hover:shadow-xl hover:shadow-cyan-900/20 transition">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 shrink-0">
                                <x-admin.icon-workshop />
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-extrabold text-white">
                                        {{ $workshop->name }}
                                    </h3>

                                    @if($workshop->status == 'activo')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-cyan-500/10 px-4 py-1.5 text-sm font-semibold text-cyan-300 border border-cyan-400/20">
                                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                            Activa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-red-500/10 px-4 py-1.5 text-sm font-semibold text-red-300 border border-red-400/20">
                                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                            Inactiva
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 flex items-start gap-2 text-slate-300">
                                    <span class="text-cyan-300 mt-0.5">
                                        <x-admin.icon-location />
                                    </span>

                                    <span>
                                        {{ $workshop->address }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 xl:w-[520px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Contacto
                                </p>

                                <div class="mt-2 flex items-center gap-2 text-white">
                                    <span class="text-cyan-300">
                                        <x-admin.icon-phone />
                                    </span>

                                    <span>
                                        {{ $workshop->phone ?: 'No registrado' }}
                                    </span>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Horario
                                </p>

                                <div class="mt-2 flex items-start gap-2 text-white">
                                    <span class="text-cyan-300 mt-0.5">
                                        <x-admin.icon-clock />
                                    </span>

                                    <span>
                                        {{ $workshop->opening_hours ?: 'No definido' }}
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row xl:flex-col gap-3 xl:w-32">

                            <a href="{{ route('admin.workshops.show', $workshop) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 px-4 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                <x-admin.icon-eye />
                                Ver
                            </a>

                            <a href="{{ route('admin.workshops.edit', $workshop) }}"
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
                        <x-admin.icon-workshop />
                    </div>

                    <p class="text-white font-bold text-lg">
                        No hay sedes o talleres registrados
                    </p>

                    <p class="text-slate-300 mt-1">
                        Registre una sede para comenzar a organizar los puntos de atención.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-4 text-white border-t border-cyan-400/10">
            {{ $workshops->links() }}
        </div>

    </div>

</div>

@endsection