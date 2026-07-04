@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

    <div class="text-center">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Módulo administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Detalle de fecha disponible
        </h1>

        <p class="text-slate-300 mt-2">
            Información de la fecha habilitada para atención vehicular.
        </p>
    </div>

    <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">

        <div class="mb-10 text-center">
            <p class="text-cyan-300 font-semibold">
                Servicio asociado
            </p>

            <h2 class="text-5xl font-extrabold text-white mt-3">
                {{ $serviceDate->serviceType->name ?? 'Servicio no disponible' }}
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 text-center">

            <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 flex flex-col items-center justify-center">
                <p class="text-slate-300">
                    Fecha de atención
                </p>

                <p class="text-3xl font-extrabold text-white mt-3">
                    {{ \Carbon\Carbon::parse($serviceDate->available_date)->format('d/m/Y') }}
                </p>
            </div>

            <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 flex flex-col items-center justify-center">
                <p class="text-slate-300">
                    Horario
                </p>

                <p class="text-3xl font-extrabold text-white mt-3">
                    {{ substr($serviceDate->start_time,0,5) }}
                    -
                    {{ substr($serviceDate->end_time,0,5) }}
                </p>
            </div>

            <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 flex flex-col items-center justify-center">
                <p class="text-slate-300">
                    Estado
                </p>

                @if($serviceDate->status=='disponible')
                    <span class="mt-4 inline-flex rounded-full bg-cyan-500/10 px-5 py-2 text-sm font-bold text-cyan-300 border border-cyan-400/20">
                        Disponible
                    </span>
                @elseif($serviceDate->status=='reservado')
                    <span class="mt-4 inline-flex rounded-full bg-blue-500/10 px-5 py-2 text-sm font-bold text-blue-300 border border-blue-400/20">
                        Reservado
                    </span>
                @elseif($serviceDate->status=='no_disponible')
                    <span class="mt-4 inline-flex rounded-full bg-red-500/10 px-5 py-2 text-sm font-bold text-red-300 border border-red-400/20">
                        No disponible
                    </span>
                @else
                    <span class="mt-4 inline-flex rounded-full bg-slate-500/10 px-5 py-2 text-sm font-bold text-slate-300 border border-slate-400/20">
                        Cancelado
                    </span>
                @endif
            </div>

        </div>

        <div class="flex justify-center gap-5 flex-wrap">

            <a href="{{ route('admin.service-dates.edit',$serviceDate) }}"
               class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-4 text-white font-bold hover:scale-105 transition">
                Editar fecha
            </a>

            <a href="{{ route('admin.service-dates.index') }}"
               class="rounded-2xl bg-slate-700 px-8 py-4 text-white font-semibold hover:bg-slate-600 transition">
                Ir a fechas
            </a>

        </div>

    </div>

</div>

@endsection