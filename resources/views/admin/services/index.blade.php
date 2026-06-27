@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Módulo administrativo
            </p>

            <h1 class="text-4xl font-extrabold text-white mt-2">
                Gestión de servicios
            </h1>

            <p class="text-slate-300 mt-2">
                Administre los servicios vehiculares disponibles para los clientes.
            </p>
        </div>

        <a href="{{ route('admin.services.create') }}"
           class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-4 text-white font-bold hover:bg-cyan-600 transition">
            Nuevo servicio
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
            <p class="text-slate-300">Total servicios</p>
            <h2 class="text-5xl font-extrabold text-white mt-2">{{ $totalServices }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Activos</p>
            <h2 class="text-5xl font-extrabold text-cyan-300 mt-2">{{ $activeServices }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Inactivos</p>
            <h2 class="text-5xl font-extrabold text-red-300 mt-2">{{ $inactiveServices }}</h2>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.services.index') }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl flex flex-col md:flex-row gap-4">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Buscar servicio o descripción..."
               class="flex-1 rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">

        <select name="status"
                class="rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">
            <option value="">Todos los estados</option>
            <option value="activo" @selected(request('status') === 'activo')>Activos</option>
            <option value="inactivo" @selected(request('status') === 'inactivo')>Inactivos</option>
        </select>

        <button type="submit"
                class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
            Buscar
        </button>

        <a href="{{ route('admin.services.index') }}"
           class="rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
            Limpiar
        </a>
    </form>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-cyan-400/10">
            <h2 class="text-xl font-bold text-white">
                Servicios registrados
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#061a33] text-cyan-300">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Servicio</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Descripción</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Duración</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Estado</th>
                        <th class="px-6 py-4 text-right text-sm font-bold">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cyan-400/10">
                    @forelse($services as $service)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4 font-semibold text-white">
                                {{ $service->name }}
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $service->description ?: 'Sin descripción' }}
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $service->estimated_minutes }} min
                            </td>

                            <td class="px-6 py-4">
                                @if($service->status === 'activo')
                                    <span class="inline-flex rounded-full bg-cyan-500/10 px-3 py-1 text-sm font-semibold text-cyan-300 border border-cyan-400/20">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-500/10 px-3 py-1 text-sm font-semibold text-red-300 border border-red-400/20">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex gap-3">
                                    <a href="{{ route('admin.services.show', $service) }}"
                                       class="rounded-xl bg-cyan-500/10 px-4 py-2 text-cyan-300 font-semibold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                        Ver
                                    </a>

                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="rounded-xl bg-blue-500/10 px-4 py-2 text-blue-300 font-semibold border border-blue-400/20 hover:bg-blue-600 hover:text-white transition">
                                        Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-300">
                                No hay servicios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 text-white">
            {{ $services->links() }}
        </div>
    </div>

</div>

@endsection