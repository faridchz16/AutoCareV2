@extends('client.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div>
                <p class="text-cyan-400 font-bold uppercase tracking-widest">
                    Centro del cliente
                </p>

                <div class="flex items-center gap-4 mt-2">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                        <x-admin.icon-dashboard />
                    </div>

                    <h1 class="text-4xl font-extrabold text-white">
                        Mis vehículos
                    </h1>
                </div>

                <p class="text-slate-300 mt-3">
                    Consulte y registre los vehículos que utilizará para solicitar mantenimientos.
                </p>
            </div>

            <a href="{{ route('client.vehicles.create') }}"
               class="inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-4 font-bold text-white hover:scale-105 transition shadow-lg shadow-cyan-900/30">
                <x-admin.icon-plus />
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

        <div class="px-8 py-5 border-b border-cyan-400/10 flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-dashboard />
            </div>

            <div>
                <h2 class="text-2xl font-bold text-white">
                    Vehículos registrados
                </h2>

                <p class="text-slate-300 mt-1">
                    Esta información será usada al momento de solicitar una atención.
                </p>
            </div>
        </div>

        <div class="p-6 space-y-5">

            @forelse($vehicles as $vehicle)

                <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 hover:-translate-y-1 hover:border-cyan-400/30 hover:shadow-xl hover:shadow-cyan-900/20 transition">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 shrink-0">
                                <x-admin.icon-dashboard />
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-2xl font-extrabold text-white">
                                        {{ $vehicle->brand }} {{ $vehicle->model }}
                                    </h3>

                                    <span class="inline-flex rounded-full bg-cyan-500/10 px-4 py-1.5 text-sm font-semibold text-cyan-300 border border-cyan-400/20">
                                        Activo
                                    </span>
                                </div>

                                <p class="text-slate-300 mt-2">
                                    Placa:
                                    <span class="text-white font-bold">
                                        {{ $vehicle->plate }}
                                    </span>
                                </p>

                                <p class="text-slate-400 text-sm mt-1">
                                    Tipo: {{ $vehicle->vehicleType->name ?? 'No registrado' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 xl:w-[720px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Año
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $vehicle->year ?? 'No registrado' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Color
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $vehicle->color ?? 'No registrado' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Kilometraje
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $vehicle->current_mileage ? number_format($vehicle->current_mileage) . ' km' : 'No registrado' }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-16 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 mb-4">
                        <x-admin.icon-dashboard />
                    </div>

                    <p class="text-white font-bold text-lg">
                        Todavía no tiene vehículos registrados
                    </p>

                    <p class="text-slate-300 mt-1">
                        Registre un vehículo para poder solicitar un mantenimiento.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-5 border-t border-cyan-400/10">
            {{ $vehicles->links() }}
        </div>

    </section>

</div>

@endsection