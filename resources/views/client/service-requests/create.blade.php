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
                Complete la información y seleccione visualmente la fecha disponible para su atención.
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

                        <option value="">Seleccione un vehículo</option>

                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
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

                    <select
                        id="service_type_id"
                        name="service_type_id"
                        class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

                        <option value="">Seleccione un servicio</option>

                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_type_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('service_type_id')
                        <p class="text-red-400 mt-2 text-sm">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-10">

                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <label class="block font-semibold text-cyan-300">
                            Fecha disponible
                        </label>

                        <p class="text-slate-400 text-sm mt-1">
                            Seleccione primero un servicio para visualizar sus fechas disponibles.
                        </p>
                    </div>
                </div>

                <input type="hidden"
                       name="service_date_id"
                       id="service_date_id"
                       value="{{ old('service_date_id') }}">

                <div
                    id="select-service-message"
                    class="rounded-2xl bg-cyan-500/10 border border-cyan-400/20 p-5 mb-5 text-cyan-300">

                    Seleccione primero un servicio para visualizar las fechas disponibles.

                </div>

                <div
                    id="dates-container"
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                    @forelse($dates as $date)

                        @php
                            $selected = old('service_date_id') == $date->id;
                            $dayName = \Carbon\Carbon::parse($date->available_date)->locale('es')->translatedFormat('l');
                            $dayNumber = \Carbon\Carbon::parse($date->available_date)->format('d');
                            $monthName = \Carbon\Carbon::parse($date->available_date)->locale('es')->translatedFormat('F');
                        @endphp

                        <button
                            type="button"
                            data-date-id="{{ $date->id }}"
                            data-service="{{ $date->service_type_id }}"
                            onclick="selectServiceDate(this)"
                            class="date-card text-left rounded-3xl border p-6 transition hover:-translate-y-1 hover:shadow-xl
                            {{ $selected
                                ? 'bg-cyan-500/20 border-cyan-400 shadow-cyan-900/30'
                                : 'bg-[#0c223d] border-cyan-400/10 hover:border-cyan-400/40' }}">

                            <div class="flex items-start justify-between gap-4">

                                <div>
                                    <p class="text-cyan-300 text-sm font-bold uppercase tracking-widest">
                                        {{ ucfirst($dayName) }}
                                    </p>

                                    <div class="flex items-end gap-2 mt-2">
                                        <span class="text-5xl font-extrabold text-white">
                                            {{ $dayNumber }}
                                        </span>

                                        <span class="text-slate-300 font-semibold mb-2">
                                            {{ ucfirst($monthName) }}
                                        </span>
                                    </div>
                                </div>

                                <span class="date-check w-8 h-8 rounded-full border flex items-center justify-center text-sm font-bold
                                    {{ $selected
                                        ? 'bg-cyan-400 border-cyan-300 text-[#031020]'
                                        : 'border-cyan-400/30 text-transparent' }}">
                                    ✓
                                </span>

                            </div>

                            <div class="mt-5 grid grid-cols-1 gap-3">

                                <div class="rounded-2xl bg-[#132b49]/80 border border-cyan-400/10 px-4 py-3">
                                    <p class="text-xs text-cyan-400 font-bold uppercase tracking-widest">
                                        Horario
                                    </p>

                                    <p class="text-white font-semibold mt-1">
                                        {{ substr($date->start_time, 0, 5) }} - {{ substr($date->end_time, 0, 5) }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-[#132b49]/80 border border-cyan-400/10 px-4 py-3">
                                    <p class="text-xs text-cyan-400 font-bold uppercase tracking-widest">
                                        Servicio relacionado
                                    </p>

                                    <p class="text-slate-200 font-semibold mt-1">
                                        {{ $date->serviceType->name ?? 'Servicio general' }}
                                    </p>
                                </div>

                            </div>

                        </button>

                    @empty

                        <div class="md:col-span-2 xl:col-span-3 rounded-3xl bg-red-500/10 border border-red-400/20 p-6 text-red-300">
                            No hay fechas disponibles por el momento.
                        </div>

                    @endforelse

                </div>

                <div
                    id="no-dates-message"
                    class="hidden rounded-2xl bg-red-500/10 border border-red-400/20 p-5 mt-5 text-red-300">

                    No hay fechas disponibles para el servicio seleccionado.

                </div>

                @error('service_date_id')
                    <p class="text-red-400 mt-3 text-sm">{{ $message }}</p>
                @enderror

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">

                <div>
                    <label class="block mb-2 font-semibold text-cyan-300">
                        Método de pago
                    </label>

                    <select name="payment_method_id"
                            class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

                        <option value="">Seleccione un método</option>

                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
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

<script>
    const serviceSelect = document.getElementById('service_type_id');
    const hiddenDateInput = document.getElementById('service_date_id');
    const message = document.getElementById('select-service-message');
    const noDatesMessage = document.getElementById('no-dates-message');
    const cards = document.querySelectorAll('.date-card');

    function resetSelectedCards() {
        hiddenDateInput.value = '';

        cards.forEach(card => {
            card.classList.remove(
                'bg-cyan-500/20',
                'border-cyan-400',
                'shadow-cyan-900/30'
            );

            card.classList.add(
                'bg-[#0c223d]',
                'border-cyan-400/10'
            );

            const check = card.querySelector('.date-check');

            check.classList.remove(
                'bg-cyan-400',
                'border-cyan-300',
                'text-[#031020]'
            );

            check.classList.add(
                'border-cyan-400/30',
                'text-transparent'
            );
        });
    }

    function filterDates() {
        const selectedService = serviceSelect.value;
        let visibleCards = 0;

        resetSelectedCards();

        cards.forEach(card => {
            card.style.display = 'none';

            if (selectedService !== '' && card.dataset.service === selectedService) {
                card.style.display = 'block';
                visibleCards++;
            }
        });

        if (selectedService === '') {
            message.classList.remove('hidden');
            noDatesMessage.classList.add('hidden');
            return;
        }

        message.classList.add('hidden');

        if (visibleCards === 0) {
            noDatesMessage.classList.remove('hidden');
        } else {
            noDatesMessage.classList.add('hidden');
        }
    }

    function selectServiceDate(button) {
        hiddenDateInput.value = button.dataset.dateId;

        cards.forEach(card => {
            card.classList.remove(
                'bg-cyan-500/20',
                'border-cyan-400',
                'shadow-cyan-900/30'
            );

            card.classList.add(
                'bg-[#0c223d]',
                'border-cyan-400/10'
            );

            const check = card.querySelector('.date-check');

            check.classList.remove(
                'bg-cyan-400',
                'border-cyan-300',
                'text-[#031020]'
            );

            check.classList.add(
                'border-cyan-400/30',
                'text-transparent'
            );
        });

        button.classList.remove(
            'bg-[#0c223d]',
            'border-cyan-400/10'
        );

        button.classList.add(
            'bg-cyan-500/20',
            'border-cyan-400',
            'shadow-cyan-900/30'
        );

        const selectedCheck = button.querySelector('.date-check');

        selectedCheck.classList.remove(
            'border-cyan-400/30',
            'text-transparent'
        );

        selectedCheck.classList.add(
            'bg-cyan-400',
            'border-cyan-300',
            'text-[#031020]'
        );
    }

    serviceSelect.addEventListener('change', filterDates);

    document.addEventListener('DOMContentLoaded', function () {
        filterDates();
    });
</script>

@endsection