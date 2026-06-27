@extends('client.layouts.app')

@section('content')

<div class="space-y-8">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">

        <div>

            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Centro del cliente
            </p>

            <h1 class="text-4xl font-extrabold text-white mt-2">
                Solicitar mantenimiento
            </h1>

            <p class="text-slate-300 mt-2">
                Complete la siguiente información para registrar una nueva solicitud de mantenimiento.
            </p>

        </div>

    </section>

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 border border-red-400/20 text-red-300 px-6 py-4">
            {{ session('error') }}
        </div>
    @endif

    <section class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">

        <form action="{{ route('client.service-requests.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>

                    <label class="block mb-2 font-semibold text-cyan-300">
                        Vehículo
                    </label>

                    <select name="vehicle_id"
                            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

                        <option value="">
                            Seleccione un vehículo
                        </option>

                        @foreach($vehicles as $vehicle)

                            <option value="{{ $vehicle->id }}"
                                {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>

                                {{ $vehicle->plate }} - {{ $vehicle->brand }} {{ $vehicle->model }}

                            </option>

                        @endforeach

                    </select>

                    @error('vehicle_id')
                        <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
                    @enderror

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-cyan-300">
                        Tipo de servicio
                    </label>

                    <select name="service_type_id"
                            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

                        <option value="">
                            Seleccione un servicio
                        </option>

                        @foreach($services as $service)

                            <option value="{{ $service->id }}"
                                {{ old('service_type_id') == $service->id ? 'selected' : '' }}>

                                {{ $service->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('service_type_id')
                        <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
                    @enderror

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-cyan-300">
                        Fecha disponible
                    </label>

                    <select name="service_date_id"
                            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

                        <option value="">
                            Seleccione una fecha
                        </option>

                        @foreach($dates as $date)

                            <option value="{{ $date->id }}"
                                {{ old('service_date_id') == $date->id ? 'selected' : '' }}>

                                {{ \Carbon\Carbon::parse($date->available_date)->format('d/m/Y') }}
                                -
                                {{ substr($date->start_time,0,5) }}

                            </option>

                        @endforeach

                    </select>

                    @error('service_date_id')
                        <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
                    @enderror

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-cyan-300">
                        Método de pago
                    </label>

                    <select name="payment_method_id"
                            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

                        <option value="">
                            Seleccione un método
                        </option>

                        @foreach($paymentMethods as $method)

                            <option value="{{ $method->id }}"
                                {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>

                                {{ $method->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('payment_method_id')
                        <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
                    @enderror

                </div>

            </div>

            <div class="mt-8">

                <label class="block mb-2 font-semibold text-cyan-300">
                    Observaciones
                </label>

                <textarea
                    name="customer_notes"
                    rows="5"
                    placeholder="Ingrese alguna observación para el mecánico..."
                    class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-4 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">{{ old('customer_notes') }}</textarea>

                @error('customer_notes')
                    <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
                @enderror

            </div>

            <div class="flex justify-end gap-4 mt-10">

                <a href="{{ route('client.dashboard') }}"
                   class="rounded-2xl bg-slate-700 px-7 py-3 font-semibold hover:bg-slate-600 transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-3 font-bold hover:scale-105 transition">
                    Registrar solicitud
                </button>

            </div>

        </form>

    </section>

</div>

@endsection