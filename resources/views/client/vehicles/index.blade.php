@extends('client.layouts.app')

@section('content')

<div class="space-y-12">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7 mb-6">

        <div class="flex items-center justify-between w-full gap-8">

            <div class="max-w-3xl">
                <p class="text-cyan-400 font-bold uppercase tracking-widest">
                    Centro del cliente
                </p>

                <h1 class="text-4xl font-extrabold text-white mt-2">
                    Mis vehículos
                </h1>

                <p class="text-slate-300 mt-2">
                    Consulte los vehículos registrados para utilizarlos al solicitar un mantenimiento.
                </p>
            </div>

            <a href="{{ route('client.vehicles.create') }}"
               class="flex-shrink-0 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-4 font-bold text-white hover:scale-105 transition duration-300 shadow-lg shadow-cyan-900/30">
                Registrar vehículo
            </a>

        </div>

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
                Vehículos registrados
            </h2>

            <p class="text-slate-300 mt-1">
                Esta información se usará únicamente para registrar solicitudes de mantenimiento.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-full">
                <thead class="bg-[#061a33]">
                    <tr>
                        <th class="px-6 py-4 text-left text-cyan-300">Placa</th>
                        <th class="px-6 py-4 text-left text-cyan-300">Tipo</th>
                        <th class="px-6 py-4 text-left text-cyan-300">Marca</th>
                        <th class="px-6 py-4 text-left text-cyan-300">Modelo</th>
                        <th class="px-6 py-4 text-left text-cyan-300">Año</th>
                        <th class="px-6 py-4 text-left text-cyan-300">Kilometraje</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cyan-400/10">

                    @forelse($vehicles as $vehicle)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-5 text-white font-semibold">
                                {{ $vehicle->plate }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $vehicle->vehicleType->name ?? 'No registrado' }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $vehicle->brand }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $vehicle->model }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $vehicle->year ?? 'No registrado' }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $vehicle->current_mileage ? number_format($vehicle->current_mileage) . ' km' : 'No registrado' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-300">
                                Todavía no tiene vehículos registrados. Presione “Registrar vehículo” para comenzar.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="px-6 py-5">
            {{ $vehicles->links() }}
        </div>

    </section>

</div>

@endsection