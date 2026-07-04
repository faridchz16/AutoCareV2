@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Módulo administrativo
            </p>

            <h1 class="text-4xl font-extrabold text-white mt-2">
                Detalle de sede
            </h1>

            <p class="text-slate-300 mt-2">
                Información registrada de la sede o taller seleccionado.
            </p>
        </div>

        <a href="{{ route('admin.workshops.index') }}"
           class="inline-flex items-center justify-center rounded-2xl bg-slate-700 px-6 py-4 text-white font-bold hover:bg-slate-600 transition">
            Volver
        </a>

    </div>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-cyan-300 font-bold mb-2">Nombre de la sede</p>
                <p class="text-white text-lg">{{ $workshop->name }}</p>
            </div>

            <div>
                <p class="text-cyan-300 font-bold mb-2">Teléfono</p>
                <p class="text-white text-lg">{{ $workshop->phone ?: 'No registrado' }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-cyan-300 font-bold mb-2">Dirección</p>
                <p class="text-white text-lg">{{ $workshop->address }}</p>
            </div>

            <div>
                <p class="text-cyan-300 font-bold mb-2">Horario de atención</p>
                <p class="text-white text-lg">{{ $workshop->opening_hours ?: 'No definido' }}</p>
            </div>

            <div>
                <p class="text-cyan-300 font-bold mb-2">Estado</p>

                @if($workshop->status == 'activo')
                    <span class="inline-flex rounded-full bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-300 border border-cyan-400/20">
                        Activa
                    </span>
                @else
                    <span class="inline-flex rounded-full bg-red-500/10 px-4 py-2 text-sm font-semibold text-red-300 border border-red-400/20">
                        Inactiva
                    </span>
                @endif
            </div>

        </div>

        <div class="flex flex-col md:flex-row gap-4 justify-end mt-8">

            <a href="{{ route('admin.workshops.edit', $workshop) }}"
               class="rounded-2xl bg-blue-500 px-6 py-3 text-white font-bold text-center hover:bg-blue-600 transition">
                Editar sede
            </a>

        </div>

    </div>

</div>

@endsection