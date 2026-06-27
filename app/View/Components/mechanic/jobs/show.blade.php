@extends('mechanic.layouts.app')

@section('content')

<div class="space-y-8">

    <div>
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Panel del mecánico
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Detalle del trabajo
        </h1>

        <p class="text-slate-300 mt-2">
            Revise la información del servicio antes de iniciar o finalizar el trabajo.
        </p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 border border-green-400/20 text-green-300 px-6 py-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-2 space-y-8">

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">

                <h2 class="text-2xl font-bold text-white mb-8">
                    Información del servicio
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-cyan-300 font-semibold">Cliente</p>
                        <p class="text-white mt-2">
                            {{ $serviceRequest->customer->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-cyan-300 font-semibold">Vehículo</p>
                        <p class="text-white mt-2">
                            {{ $serviceRequest->vehicle_brand }}
                            {{ $serviceRequest->vehicle_model }}
                        </p>
                    </div>

                    <div>
                        <p class="text-cyan-300 font-semibold">Placa</p>
                        <p class="text-white mt-2">
                            {{ $serviceRequest->vehicle_plate }}
                        </p>
                    </div>

                    <div>
                        <p class="text-cyan-300 font-semibold">Kilometraje</p>
                        <p class="text-white mt-2">
                            {{ number_format($serviceRequest->current_mileage) }} km
                        </p>
                    </div>

                    <div>
                        <p class="text-cyan-300 font-semibold">Servicio</p>
                        <p class="text-white mt-2">
                            {{ $serviceRequest->serviceType->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-cyan-300 font-semibold">Forma de pago</p>
                        <p class="text-white mt-2">
                            {{ $serviceRequest->paymentMethod->name }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">

                <h2 class="text-2xl font-bold text-white mb-6">
                    Observaciones del cliente
                </h2>

                <p class="text-slate-300 leading-8">
                    {{ $serviceRequest->customer_notes ?: 'El cliente no registró observaciones.' }}
                </p>

            </div>

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">

                <h2 class="text-2xl font-bold text-white mb-6">
                    Observaciones del administrador
                </h2>

                <p class="text-slate-300 leading-8">
                    {{ $serviceRequest->admin_notes ?: 'No existen observaciones administrativas.' }}
                </p>

            </div>

        </div>

        <div class="space-y-8">

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-8">

                <h2 class="text-2xl font-bold text-white mb-8">
                    Acciones
                </h2>

                @if($serviceRequest->status == 'confirmado')

                    <form method="POST"
                          action="{{ route('mechanic.jobs.update',$serviceRequest) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden"
                               name="action"
                               value="start">

                        <button
                            class="w-full rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 py-4 font-bold hover:scale-105 transition">
                            Iniciar trabajo
                        </button>

                    </form>

                @elseif($serviceRequest->status == 'en_proceso')

                    <form method="POST"
                          action="{{ route('mechanic.jobs.update',$serviceRequest) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden"
                               name="action"
                               value="finish">

                        <button
                            class="w-full rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 py-4 font-bold hover:scale-105 transition">
                            Finalizar trabajo
                        </button>

                    </form>

                @else

                    <div class="rounded-2xl bg-cyan-500/10 border border-cyan-400/20 p-5 text-center text-cyan-300">

                        Este trabajo ya no admite cambios.

                    </div>

                @endif

            </div>

            <a href="{{ route('mechanic.jobs.index') }}"
               class="block rounded-2xl bg-slate-700 text-center py-4 font-semibold hover:bg-slate-600 transition">

                Volver

            </a>

        </div>

    </div>

</div>

@endsection