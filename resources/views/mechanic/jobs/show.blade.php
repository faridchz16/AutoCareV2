@extends('mechanic.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Centro del mecánico
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Detalle del trabajo
        </h1>

        <p class="text-slate-300 mt-2">
            Revise la información del servicio asignado y actualice el avance del trabajo.
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

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <section class="xl:col-span-2 space-y-8">

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">
                    Información del servicio
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6">
                        <p class="text-cyan-300 font-semibold">Cliente</p>
                        <p class="text-white font-bold mt-2">
                            {{ $serviceRequest->customer->name ?? 'Cliente no disponible' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6">
                        <p class="text-cyan-300 font-semibold">Servicio</p>
                        <p class="text-white font-bold mt-2">
                            {{ $serviceRequest->serviceType->name ?? 'Servicio no disponible' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6">
                        <p class="text-cyan-300 font-semibold">Vehículo</p>
                        <p class="text-white font-bold mt-2">
                            {{ $serviceRequest->vehicle_brand }} {{ $serviceRequest->vehicle_model }}
                        </p>
                        <p class="text-slate-400 text-sm mt-1">
                            Placa: {{ $serviceRequest->vehicle_plate }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6">
                        <p class="text-cyan-300 font-semibold">Kilometraje</p>
                        <p class="text-white font-bold mt-2">
                            {{ $serviceRequest->current_mileage ? number_format($serviceRequest->current_mileage) . ' km' : 'No registrado' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6">
                        <p class="text-cyan-300 font-semibold">Fecha programada</p>

                        @if($serviceRequest->serviceDate)
                            <p class="text-white font-bold mt-2">
                                {{ \Carbon\Carbon::parse($serviceRequest->serviceDate->available_date)->format('d/m/Y') }}
                            </p>
                            <p class="text-slate-400 text-sm mt-1">
                                {{ substr($serviceRequest->serviceDate->start_time, 0, 5) }}
                                -
                                {{ substr($serviceRequest->serviceDate->end_time, 0, 5) }}
                            </p>
                        @else
                            <p class="text-slate-300 mt-2">Fecha no disponible</p>
                        @endif
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6">
                        <p class="text-cyan-300 font-semibold">Forma de pago</p>
                        <p class="text-white font-bold mt-2">
                            {{ $serviceRequest->paymentMethod->name ?? 'No registrada' }}
                        </p>
                    </div>

                </div>
            </div>

        </section>

        <aside class="space-y-8">

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">
                    Estado actual
                </h2>

                <span class="inline-flex rounded-full px-4 py-2 text-sm font-semibold border
                    @if($serviceRequest->status === 'en_proceso')
                        bg-blue-500/10 text-blue-300 border-blue-400/20
                    @elseif($serviceRequest->status === 'finalizado_mecanico')
                        bg-green-500/10 text-green-300 border-green-400/20
                    @elseif($serviceRequest->status === 'listo_para_recoger')
                        bg-green-500/10 text-green-300 border-green-400/20
                    @elseif($serviceRequest->status === 'cancelado')
                        bg-red-500/10 text-red-300 border-red-400/20
                    @else
                        bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                    @endif">
                    {{ str_replace('_', ' ', ucfirst($serviceRequest->status)) }}
                </span>

                <div class="mt-6 text-sm text-slate-300">
                    @if($serviceRequest->mechanic_finished)
                        <p class="text-green-300 font-semibold">
                            Trabajo finalizado por el mecánico.
                        </p>
                    @else
                        <p>
                            El trabajo aún está pendiente de finalización.
                        </p>
                    @endif
                </div>
            </div>

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">
                    Acciones del mecánico
                </h2>

                @if($serviceRequest->status === 'confirmado' || $serviceRequest->status === 'en_taller')
                    <form method="POST"
                          action="{{ route('mechanic.jobs.update', $serviceRequest) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="action" value="start">

                        <button type="submit"
                                class="w-full rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-4 text-white font-bold hover:scale-105 transition">
                            Iniciar trabajo
                        </button>
                    </form>

                @elseif($serviceRequest->status === 'en_proceso')
                    <form method="POST"
                          action="{{ route('mechanic.jobs.update', $serviceRequest) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="action" value="finish">

                        <button type="submit"
                                class="w-full rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4 text-white font-bold hover:scale-105 transition">
                            Finalizar trabajo
                        </button>
                    </form>

                @else
                    <div class="rounded-2xl bg-slate-500/10 border border-slate-400/20 px-5 py-4 text-slate-300 text-center">
                        No hay acciones disponibles para este estado.
                    </div>
                @endif
            </div>

            <a href="{{ route('mechanic.jobs.index') }}"
               class="block text-center rounded-2xl bg-slate-700 px-6 py-4 text-white font-semibold hover:bg-slate-600 transition">
                Volver a mis trabajos
            </a>

        </aside>

    </div>

</div>

@endsection