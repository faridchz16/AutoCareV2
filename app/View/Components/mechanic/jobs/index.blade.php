@extends('mechanic.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Panel del mecánico
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Mis trabajos
        </h1>

        <p class="text-slate-300 mt-2">
            Revise las solicitudes de mantenimiento que fueron asignadas a su cuenta.
        </p>
    </section>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 border border-green-400/20 text-green-300 px-6 py-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 border border-red-400/20 text-red-300 px-6 py-4">
            {{ session('error') }}
        </div>
    @endif

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-8 py-5 border-b border-cyan-400/10">
            <h2 class="text-2xl font-bold text-white">
                Trabajos asignados
            </h2>

            <p class="text-slate-300 mt-1">
                Solo se muestran los servicios asignados por el administrador.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px]">
                <thead class="bg-[#061a33] text-cyan-300">
                    <tr>
                        <th class="px-6 py-4 text-left">Cliente</th>
                        <th class="px-6 py-4 text-left">Vehículo</th>
                        <th class="px-6 py-4 text-left">Servicio</th>
                        <th class="px-6 py-4 text-left">Fecha</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-center">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cyan-400/10">

                    @forelse($jobs as $job)

                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-5 text-white font-semibold">
                                {{ $job->customer->name ?? 'Cliente no disponible' }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $job->vehicle_brand }} {{ $job->vehicle_model }}
                                <span class="block text-sm text-slate-400 mt-1">
                                    Placa: {{ $job->vehicle_plate }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $job->serviceType->name ?? 'Servicio no disponible' }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                @if($job->serviceDate)
                                    {{ \Carbon\Carbon::parse($job->serviceDate->available_date)->format('d/m/Y') }}
                                    <span class="block text-sm text-slate-400 mt-1">
                                        {{ substr($job->serviceDate->start_time, 0, 5) }} - {{ substr($job->serviceDate->end_time, 0, 5) }}
                                    </span>
                                @else
                                    Fecha no disponible
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                    @if($job->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($job->status === 'finalizado_mecanico') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($job->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($job->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                    @else bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($job->status)) }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('mechanic.jobs.show', $job) }}"
                                   class="rounded-xl bg-cyan-500/10 border border-cyan-400/20 px-4 py-2 text-cyan-300 font-semibold hover:bg-cyan-500 hover:text-white transition">
                                    Ver detalle
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-300">
                                No tiene trabajos asignados por el momento.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="px-6 py-5">
            {{ $jobs->links() }}
        </div>

    </section>

</div>

@endsection