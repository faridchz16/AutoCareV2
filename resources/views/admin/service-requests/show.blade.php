@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    <div class="text-center">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Centro administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Gestión de solicitud de atención
        </h1>

        <p class="text-slate-300 mt-2">
            Revise la atención solicitada, asigne un mecánico, defina el costo y controle el avance del servicio.
        </p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 px-5 py-4 text-green-300 border border-green-400/20 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 px-5 py-4 text-red-300 border border-red-400/20 text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-2 space-y-8">

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">
                <h2 class="text-2xl font-extrabold text-white mb-8 text-center">
                    Información de la atención
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center">

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8">
                        <p class="text-cyan-300 font-semibold">Cliente</p>
                        <p class="text-white font-bold mt-3">
                            {{ $serviceRequest->customer->name ?? 'Cliente no disponible' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8">
                        <p class="text-cyan-300 font-semibold">Servicio</p>
                        <p class="text-white font-bold mt-3">
                            {{ $serviceRequest->serviceType->name ?? 'Servicio no disponible' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8">
                        <p class="text-cyan-300 font-semibold">Vehículo</p>
                        <p class="text-white font-bold mt-3">
                            {{ $serviceRequest->vehicle_brand }} {{ $serviceRequest->vehicle_model }}
                        </p>
                        <p class="text-slate-400 text-sm mt-2">
                            Placa: {{ $serviceRequest->vehicle_plate }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8">
                        <p class="text-cyan-300 font-semibold">Kilometraje</p>
                        <p class="text-white font-bold mt-3">
                            {{ $serviceRequest->current_mileage ? number_format($serviceRequest->current_mileage) . ' km' : 'No registrado' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8">
                        <p class="text-cyan-300 font-semibold">Fecha de atención</p>

                        @if($serviceRequest->serviceDate)
                            <p class="text-white font-bold mt-3">
                                {{ \Carbon\Carbon::parse($serviceRequest->serviceDate->available_date)->format('d/m/Y') }}
                            </p>
                            <p class="text-slate-400 text-sm mt-2">
                                {{ substr($serviceRequest->serviceDate->start_time, 0, 5) }} - {{ substr($serviceRequest->serviceDate->end_time, 0, 5) }}
                            </p>
                        @else
                            <p class="text-slate-300 mt-3">Fecha no disponible</p>
                        @endif
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8">
                        <p class="text-cyan-300 font-semibold">Forma de pago</p>
                        <p class="text-white font-bold mt-3">
                            {{ $serviceRequest->paymentMethod->name ?? 'No registrada' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 md:col-span-2">
                        <p class="text-cyan-300 font-semibold">Costo del servicio</p>
                        <p class="text-white font-extrabold text-4xl mt-3">
                            {{ $serviceRequest->amount ? 'S/. ' . number_format($serviceRequest->amount, 2) : 'Pendiente de asignar' }}
                        </p>
                    </div>

                </div>
            </div>

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">
                <h2 class="text-2xl font-extrabold text-white mb-8 text-center">
                    Observaciones
                </h2>

                <div class="space-y-6">
                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 text-center">
                        <p class="text-cyan-300 font-semibold mb-3">
                            Observación del cliente
                        </p>

                        <p class="text-slate-300 leading-8">
                            {{ $serviceRequest->customer_notes ?: 'El cliente no registró observaciones.' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-cyan-500/10 border border-cyan-400/20 p-8 text-center">
                        <p class="text-cyan-300 font-semibold mb-3">
                            Observación administrativa
                        </p>

                        <p class="text-slate-300 leading-8">
                            {{ $serviceRequest->admin_notes ?: 'Aún no se registraron observaciones administrativas.' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-8">

            <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">
                <h2 class="text-2xl font-extrabold text-white mb-8 text-center">
                    Control administrativo
                </h2>

                <form action="{{ route('admin.service-requests.update', $serviceRequest) }}"
                      method="POST"
                      data-confirm="¿Desea actualizar esta solicitud de atención?">

                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block text-cyan-300 font-semibold mb-2">
                            Mecánico asignado
                        </label>

                        <select name="mechanic_id"
                                class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">
                            <option value="">Sin asignar</option>

                            @foreach($mechanics as $mechanic)
                                <option value="{{ $mechanic->id }}"
                                    @selected(old('mechanic_id', $serviceRequest->mechanic_id) == $mechanic->id)>
                                    {{ $mechanic->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('mechanic_id')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-cyan-300 font-semibold mb-2">
                            Costo del servicio (S/.)
                        </label>

                        <input type="number"
                               step="0.01"
                               min="0"
                               name="amount"
                               value="{{ old('amount', $serviceRequest->amount) }}"
                               class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

                        @error('amount')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-cyan-300 font-semibold mb-2">
                            Estado del pago
                        </label>

                        <select name="payment_status"
                                class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">
                            <option value="pendiente" @selected(old('payment_status', $serviceRequest->payment_status) === 'pendiente')>Pendiente</option>
                            <option value="pagado" @selected(old('payment_status', $serviceRequest->payment_status) === 'pagado')>Pagado</option>
                            <option value="reembolsado" @selected(old('payment_status', $serviceRequest->payment_status) === 'reembolsado')>Reembolsado</option>
                        </select>

                        @error('payment_status')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-cyan-300 font-semibold mb-2">
                            Estado de la solicitud
                        </label>

                        <select name="status"
                                class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">
                            <option value="pendiente" @selected(old('status', $serviceRequest->status) === 'pendiente')>Pendiente</option>
                            <option value="confirmado" @selected(old('status', $serviceRequest->status) === 'confirmado')>Confirmado</option>
                            <option value="en_taller" @selected(old('status', $serviceRequest->status) === 'en_taller')>En taller</option>
                            <option value="en_proceso" @selected(old('status', $serviceRequest->status) === 'en_proceso')>En proceso</option>
                            <option value="finalizado_mecanico" @selected(old('status', $serviceRequest->status) === 'finalizado_mecanico')>Finalizado por mecánico</option>
                            <option value="listo_para_recoger" @selected(old('status', $serviceRequest->status) === 'listo_para_recoger')>Listo para recoger</option>
                            <option value="cancelado" @selected(old('status', $serviceRequest->status) === 'cancelado')>Cancelado</option>
                        </select>

                        @error('status')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-cyan-300 font-semibold mb-2">
                            Observación administrativa
                        </label>

                        <textarea name="admin_notes"
                                  rows="4"
                                  placeholder="Ingrese una observación interna"
                                  class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">{{ old('admin_notes', $serviceRequest->admin_notes) }}</textarea>

                        @error('admin_notes')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 mb-8">
                        <label class="flex items-start gap-3">
                            <input type="checkbox"
                                   name="admin_confirmed"
                                   value="1"
                                   class="mt-1 rounded border-cyan-500/30 text-cyan-500 focus:ring-cyan-500"
                                   @checked(old('admin_confirmed', $serviceRequest->admin_confirmed))>

                            <span>
                                <span class="block font-semibold text-white">
                                    Confirmar servicio listo
                                </span>

                                <span class="block text-sm text-slate-400 mt-1">
                                    Use esta opción cuando el mecánico haya terminado y el vehículo esté listo para recoger.
                                </span>
                            </span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-4 text-white font-bold hover:scale-105 transition">
                        Guardar cambios
                    </button>
                </form>
            </div>

            <a href="{{ route('admin.service-requests.index') }}"
               class="block text-center rounded-2xl bg-slate-700 px-6 py-4 text-white font-semibold hover:bg-slate-600 transition">
                Ir a solicitudes
            </a>

        </div>

    </div>

</div>

@endsection