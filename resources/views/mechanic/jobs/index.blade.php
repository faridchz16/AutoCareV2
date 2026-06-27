@extends('mechanic.layouts.app')

@section('content')

<div class="space-y-7">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-cyan-400 font-bold uppercase tracking-widest">
                    Centro del mecánico
                </p>

                <h1 class="text-4xl font-extrabold text-white mt-2">
                    Mis trabajos
                </h1>

                <p class="text-slate-300 mt-2">
                    Consulte las solicitudes que fueron asignadas para su atención.
                </p>

            </div>

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
                Revise el estado de cada servicio y continúe con la atención.
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-[#061a33]">

                    <tr>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Cliente
                        </th>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Vehículo
                        </th>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Servicio
                        </th>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Fecha
                        </th>

                        <th class="px-6 py-4 text-center text-cyan-300">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center text-cyan-300">
                            Acción
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-cyan-400/10">

                    @forelse($jobs as $job)

                        <tr class="hover:bg-white/5 transition">

                            <td class="px-6 py-5 text-white font-semibold">
                                {{ $job->customer->name }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $job->vehicle_brand }}
                                {{ $job->vehicle_model }}

                                <span class="block text-sm text-slate-500">
                                    {{ $job->vehicle_plate }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $job->serviceType->name }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">

                                @if($job->serviceDate)

                                    {{ \Carbon\Carbon::parse($job->serviceDate->available_date)->format('d/m/Y') }}

                                @else

                                    --

                                @endif

                            </td>

                            <td class="px-6 py-5 text-center">

                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                @if($job->status=='pendiente')
                                    bg-yellow-500/10 text-yellow-300 border-yellow-500/20
                                @elseif($job->status=='en_proceso')
                                    bg-blue-500/10 text-blue-300 border-blue-500/20
                                @elseif($job->status=='listo_para_recoger')
                                    bg-green-500/10 text-green-300 border-green-500/20
                                @else
                                    bg-cyan-500/10 text-cyan-300 border-cyan-500/20
                                @endif">

                                    {{ ucfirst(str_replace('_',' ',$job->status)) }}

                                </span>

                            </td>

                            <td class="px-6 py-5 text-center">

                                <a href="{{ route('mechanic.jobs.show',$job) }}"
                                   class="rounded-xl bg-cyan-500/10 border border-cyan-400/20 px-4 py-2 text-cyan-300 hover:bg-cyan-500 hover:text-white transition">

                                    Ver detalle

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-12 text-center text-slate-300">

                                No tiene trabajos asignados.

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