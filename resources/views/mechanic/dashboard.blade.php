@extends('mechanic.layouts.app')

@section('content')

<div class="space-y-8">

    <div>

        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Panel del mecánico
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Bienvenido, {{ auth()->user()->name }}
        </h1>

        <p class="text-slate-300 mt-2"></p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl">

            <p class="text-slate-300">
                Trabajos asignados
            </p>

            <h2 class="text-5xl font-extrabold text-cyan-300 mt-4">
                {{ $assignedJobs }}
            </h2>

        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl">

            <p class="text-slate-300">
                En proceso
            </p>

            <h2 class="text-5xl font-extrabold text-blue-300 mt-4">
                {{ $inProgressJobs }}
            </h2>

        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl">

            <p class="text-slate-300">
                Finalizados
            </p>

            <h2 class="text-5xl font-extrabold text-green-300 mt-4">
                {{ $completedJobs }}
            </h2>

        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-7 shadow-xl">

            <p class="text-slate-300">
                Trabajos para hoy
            </p>

            <h2 class="text-5xl font-extrabold text-yellow-300 mt-4">
                {{ $todayJobs }}
            </h2>

        </div>

    </div>

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-8 py-6 border-b border-cyan-400/10">

            <h2 class="text-2xl font-bold text-white">
                Últimos trabajos asignados
            </h2>

            <p class="text-slate-300 mt-1">
                Solicitudes recientemente asignadas para su atención.
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

                    </tr>

                </thead>

                <tbody class="divide-y divide-cyan-400/10">

                    @forelse($recentJobs as $job)

                        <tr class="hover:bg-white/5 transition">

                            <td class="px-6 py-5 text-white">
                                {{ $job->customer->name }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $job->vehicle_brand }}
                                {{ $job->vehicle_model }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $job->serviceType->name }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">

                                @if($job->serviceDate)

                                    {{ \Carbon\Carbon::parse($job->serviceDate->available_date)->format('d/m/Y') }}

                                @endif

                            </td>

                            <td class="px-6 py-5 text-center">

                                <span class="rounded-full bg-cyan-500/10 border border-cyan-400/20 px-3 py-1 text-cyan-300 text-sm">

                                    {{ ucfirst(str_replace('_',' ',$job->status)) }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-12 text-center text-slate-300">

                                No tiene trabajos asignados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</div>

@endsection