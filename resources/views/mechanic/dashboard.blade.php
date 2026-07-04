@extends('mechanic.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Panel del mecánico
        </p>

        <div class="flex items-center gap-4 mt-2">
            <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-tool />
            </div>

            <div>
                <h1 class="text-4xl font-extrabold text-white">
                    Bienvenido, {{ auth()->user()->name }}
                </h1>

                <p class="text-slate-300 mt-2">
                    Revise sus trabajos asignados, continúe atenciones y finalice servicios completados.
                </p>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl hover:-translate-y-1 transition">
            <p class="text-slate-300">Trabajos asignados</p>
            <h2 class="text-5xl font-extrabold text-cyan-300 mt-4">{{ $assignedJobs }}</h2>
            <p class="text-slate-400 mt-2">Total de solicitudes asignadas</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl hover:-translate-y-1 transition">
            <p class="text-slate-300">En proceso</p>
            <h2 class="text-5xl font-extrabold text-blue-300 mt-4">{{ $inProgressJobs }}</h2>
            <p class="text-slate-400 mt-2">Trabajos actualmente en atención</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl hover:-translate-y-1 transition">
            <p class="text-slate-300">Finalizados</p>
            <h2 class="text-5xl font-extrabold text-green-300 mt-4">{{ $completedJobs }}</h2>
            <p class="text-slate-400 mt-2">Servicios terminados</p>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl hover:-translate-y-1 transition">
            <p class="text-slate-300">Trabajos para hoy</p>
            <h2 class="text-5xl font-extrabold text-yellow-300 mt-4">{{ $todayJobs }}</h2>
            <p class="text-slate-400 mt-2">Atenciones programadas hoy</p>
        </div>

    </section>

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-8 py-6 border-b border-cyan-400/10 flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-clipboard />
            </div>

            <div>
                <h2 class="text-2xl font-bold text-white">
                    Últimos trabajos asignados
                </h2>

                <p class="text-slate-300 mt-1">
                    Solicitudes recientemente asignadas para su atención.
                </p>
            </div>
        </div>

        <div class="p-6 space-y-5">

            @forelse($recentJobs as $job)

                <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 hover:-translate-y-1 hover:border-cyan-400/30 hover:shadow-xl hover:shadow-cyan-900/20 transition">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div>
                            <h3 class="text-xl font-extrabold text-white">
                                {{ $job->serviceType->name ?? 'Servicio no disponible' }}
                            </h3>

                            <p class="text-slate-300 mt-2">
                                Cliente:
                                <span class="text-white font-semibold">
                                    {{ $job->customer->name ?? 'Cliente no disponible' }}
                                </span>
                            </p>

                            <p class="text-slate-400 text-sm mt-1">
                                Vehículo: {{ $job->vehicle_brand }} {{ $job->vehicle_model }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 xl:w-[520px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Fecha
                                </p>

                                @if($job->serviceDate)
                                    <p class="text-white font-semibold mt-2">
                                        {{ \Carbon\Carbon::parse($job->serviceDate->available_date)->format('d/m/Y') }}
                                    </p>

                                    <p class="text-slate-400 text-sm mt-1">
                                        {{ substr($job->serviceDate->start_time, 0, 5) }}
                                        -
                                        {{ substr($job->serviceDate->end_time, 0, 5) }}
                                    </p>
                                @else
                                    <p class="text-slate-300 mt-2">Fecha no disponible</p>
                                @endif
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Estado
                                </p>

                                <span class="inline-flex mt-2 rounded-full px-3 py-1 text-sm font-semibold border
                                    @if($job->status === 'pendiente') bg-yellow-500/10 text-yellow-300 border-yellow-400/20
                                    @elseif($job->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($job->status === 'finalizado_mecanico') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($job->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($job->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                    @else bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @endif">
                                    {{ ucfirst(str_replace('_',' ',$job->status)) }}
                                </span>
                            </div>

                        </div>

                        <div class="xl:w-40">
                            <a href="{{ route('mechanic.jobs.show', $job) }}"
                               class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 px-5 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                <x-admin.icon-eye />
                                Ver detalle
                            </a>
                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-16 text-center">
                    <p class="text-white font-bold text-lg">
                        No tiene trabajos asignados
                    </p>

                    <p class="text-slate-300 mt-1">
                        Cuando el administrador le asigne una atención, aparecerá en esta sección.
                    </p>
                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection