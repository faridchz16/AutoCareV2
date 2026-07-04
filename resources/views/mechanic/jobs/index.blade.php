@extends('mechanic.layouts.app')

@section('content')

<div class="space-y-7">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <div>
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Centro del mecánico
            </p>

            <h1 class="text-4xl font-extrabold text-white mt-2">
                Mis trabajos
            </h1>

            <p class="text-slate-300 mt-2">
                Consulte las solicitudes asignadas y continúe con la atención del servicio.
            </p>
        </div>
    </section>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 border border-green-400/20 text-green-300 px-6 py-4">
            {{ session('success') }}
        </div>
    @endif

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-8 py-5 border-b border-cyan-400/10">
            <h2 class="text-2xl font-bold text-white">
                Trabajos asignados
            </h2>

            <p class="text-slate-300 mt-1">
                Revise el cliente, vehículo, servicio y estado de cada atención.
            </p>
        </div>

        <div class="p-6 space-y-5">

            @forelse($jobs as $job)

                <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 hover:-translate-y-1 hover:border-cyan-400/30 hover:shadow-xl hover:shadow-cyan-900/20 transition">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 shrink-0">
                                <x-admin.icon-tool />
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-extrabold text-white">
                                        {{ $job->serviceType->name ?? 'Servicio no disponible' }}
                                    </h3>

                                    <span class="inline-flex rounded-full px-4 py-1.5 text-sm font-semibold border
                                        @if($job->status=='pendiente') bg-yellow-500/10 text-yellow-300 border-yellow-500/20
                                        @elseif($job->status=='en_proceso') bg-blue-500/10 text-blue-300 border-blue-500/20
                                        @elseif($job->status=='finalizado_mecanico') bg-green-500/10 text-green-300 border-green-500/20
                                        @elseif($job->status=='listo_para_recoger') bg-green-500/10 text-green-300 border-green-500/20
                                        @elseif($job->status=='cancelado') bg-red-500/10 text-red-300 border-red-500/20
                                        @else bg-cyan-500/10 text-cyan-300 border-cyan-500/20
                                        @endif">
                                        {{ ucfirst(str_replace('_',' ',$job->status)) }}
                                    </span>
                                </div>

                                <p class="text-slate-300 mt-2">
                                    Cliente:
                                    <span class="text-white font-semibold">
                                        {{ $job->customer->name ?? 'Cliente no disponible' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 xl:w-[760px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Vehículo
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $job->vehicle_brand }} {{ $job->vehicle_model }}
                                </p>

                                <p class="text-slate-400 text-sm mt-1">
                                    Placa: {{ $job->vehicle_plate }}
                                </p>
                            </div>

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
                                    Pago
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $job->paymentMethod->name ?? 'No registrado' }}
                                </p>

                                <p class="text-slate-400 text-sm mt-1">
                                    S/. {{ number_format($job->amount ?? 0, 2) }}
                                </p>
                            </div>

                        </div>

                        <div class="xl:w-40">
                            <a href="{{ route('mechanic.jobs.show',$job) }}"
                               class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 px-5 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                <x-admin.icon-eye />
                                Ver detalle
                            </a>
                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-14 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 mb-4">
                        <x-admin.icon-tool />
                    </div>

                    <p class="text-white font-bold text-lg">
                        No tiene trabajos asignados
                    </p>

                    <p class="text-slate-300 mt-1">
                        Cuando el administrador le asigne un servicio, aparecerá en esta sección.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-5 border-t border-cyan-400/10">
            {{ $jobs->links() }}
        </div>

    </section>

</div>

@endsection