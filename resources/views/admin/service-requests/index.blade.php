@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div>
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Centro administrativo
        </p>

        <div class="flex items-center gap-4 mt-2">
            <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-clipboard />
            </div>

            <h1 class="text-4xl font-extrabold text-white">
                Solicitudes de atención
            </h1>
        </div>

        <p class="text-slate-300 mt-3">
            Supervise las solicitudes registradas, asigne mecánicos y controle el estado de cada servicio.
        </p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-500/10 px-5 py-4 text-green-300 border border-green-400/20">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 px-5 py-4 text-red-300 border border-red-400/20">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Total solicitudes</p>
            <h2 class="text-5xl font-extrabold text-white mt-3">{{ $totalRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Pendientes</p>
            <h2 class="text-5xl font-extrabold text-cyan-300 mt-3">{{ $pendingRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">En proceso</p>
            <h2 class="text-5xl font-extrabold text-sky-300 mt-3">{{ $processRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Listas para recoger</p>
            <h2 class="text-5xl font-extrabold text-teal-300 mt-3">{{ $readyRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Pagos pendientes</p>
            <h2 class="text-5xl font-extrabold text-blue-300 mt-3">{{ $pendingPayments }}</h2>
        </div>

    </div>

    <form method="GET"
          action="{{ route('admin.service-requests.index') }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl grid grid-cols-1 xl:grid-cols-5 gap-4">

        <div class="relative xl:col-span-2">
            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-cyan-300">
                <x-admin.icon-search />
            </div>

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Buscar cliente, placa, vehículo o servicio..."
                   class="w-full rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 pl-14 pr-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

        <select name="status"
                class="rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">
            <option value="">Todos los estados</option>
            <option value="pendiente" @selected(request('status') === 'pendiente')>Pendiente</option>
            <option value="confirmado" @selected(request('status') === 'confirmado')>Confirmado</option>
            <option value="en_taller" @selected(request('status') === 'en_taller')>En taller</option>
            <option value="en_proceso" @selected(request('status') === 'en_proceso')>En proceso</option>
            <option value="finalizado_mecanico" @selected(request('status') === 'finalizado_mecanico')>Finalizado por mecánico</option>
            <option value="validado_administrador" @selected(request('status') === 'validado_administrador')>Validado por administrador</option>
            <option value="listo_para_recoger" @selected(request('status') === 'listo_para_recoger')>Listo para recoger</option>
            <option value="cancelado" @selected(request('status') === 'cancelado')>Cancelado</option>
        </select>

        <select name="payment_status"
                class="rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">
            <option value="">Todos los pagos</option>
            <option value="pendiente" @selected(request('payment_status') === 'pendiente')>Pendiente</option>
            <option value="pagado" @selected(request('payment_status') === 'pagado')>Pagado</option>
            <option value="validado" @selected(request('payment_status') === 'validado')>Validado</option>
            <option value="observado" @selected(request('payment_status') === 'observado')>Observado</option>
            <option value="reembolsado" @selected(request('payment_status') === 'reembolsado')>Reembolsado</option>
        </select>

        <div class="flex gap-3">
            <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
                <x-admin.icon-search />
                Buscar
            </button>

            <a href="{{ route('admin.service-requests.index') }}"
               class="flex-1 rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
                Limpiar
            </a>
        </div>

    </form>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-6 py-5 border-b border-cyan-400/10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300">
                <x-admin.icon-clipboard />
            </div>

            <div>
                <h2 class="text-xl font-bold text-white">
                    Atenciones registradas
                </h2>

                <p class="text-sm text-slate-300 mt-1">
                    Listado de solicitudes registradas por los clientes.
                </p>
            </div>
        </div>

        <div class="p-6 space-y-5">

            @forelse($requests as $request)

                @php
                    $paymentStatusText = [
                        'pendiente' => 'Pendiente',
                        'pagado' => 'Pagado',
                        'validado' => 'Validado',
                        'observado' => 'Observado',
                        'reembolsado' => 'Reembolsado',
                    ][$request->payment_status ?? 'pendiente'] ?? 'Pendiente';

                    $serviceStatusText = [
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'en_taller' => 'En taller',
                        'en_proceso' => 'En proceso',
                        'finalizado_mecanico' => 'Finalizado por mecánico',
                        'validado_administrador' => 'Validado por administrador',
                        'listo_para_recoger' => 'Listo para recoger',
                        'cancelado' => 'Cancelado',
                    ][$request->status] ?? str_replace('_', ' ', ucfirst($request->status));
                @endphp

                <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-6 hover:-translate-y-1 hover:border-cyan-400/30 hover:shadow-xl hover:shadow-cyan-900/20 transition">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 shrink-0">
                                <x-admin.icon-tool />
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-extrabold text-white">
                                        {{ $request->serviceType->name ?? 'Servicio no disponible' }}
                                    </h3>

                                    <span class="inline-flex rounded-full px-4 py-1.5 text-sm font-semibold border
                                        @if($request->status === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                        @elseif($request->status === 'confirmado') bg-blue-500/10 text-blue-300 border-blue-400/20
                                        @elseif($request->status === 'en_taller') bg-sky-500/10 text-sky-300 border-sky-400/20
                                        @elseif($request->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                                        @elseif($request->status === 'finalizado_mecanico') bg-teal-500/10 text-teal-300 border-teal-400/20
                                        @elseif($request->status === 'validado_administrador') bg-teal-500/10 text-teal-300 border-teal-400/20
                                        @elseif($request->status === 'listo_para_recoger') bg-teal-500/10 text-teal-300 border-teal-400/20
                                        @elseif($request->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                        @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                        @endif">
                                        {{ $serviceStatusText }}
                                    </span>
                                </div>

                                <p class="text-slate-300 mt-2">
                                    Cliente:
                                    <span class="text-white font-semibold">
                                        {{ $request->customer->name ?? 'Cliente no disponible' }}
                                    </span>
                                </p>

                                <p class="text-slate-400 text-sm mt-1">
                                    Vehículo: {{ $request->vehicle_brand }} {{ $request->vehicle_model }}
                                    · Placa: {{ $request->vehicle_plate }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 xl:w-[920px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Fecha y hora
                                </p>

                                @if($request->serviceDate)
                                    <p class="text-white font-semibold mt-2">
                                        {{ \Carbon\Carbon::parse($request->serviceDate->available_date)->format('d/m/Y') }}
                                    </p>

                                    <p class="text-slate-400 text-sm mt-1">
                                        {{ substr($request->serviceDate->start_time, 0, 5) }}
                                        -
                                        {{ substr($request->serviceDate->end_time, 0, 5) }}
                                    </p>
                                @else
                                    <p class="text-slate-300 mt-2">Fecha no disponible</p>
                                @endif
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Pago
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $request->paymentMethod->name ?? 'No registrado' }}
                                </p>

                                <span class="inline-flex mt-2 rounded-full px-3 py-1 text-sm font-semibold border
                                    @if(($request->payment_status ?? 'pendiente') === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @elseif($request->payment_status === 'pagado') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->payment_status === 'validado') bg-teal-500/10 text-teal-300 border-teal-400/20
                                    @elseif($request->payment_status === 'observado') bg-orange-500/10 text-orange-300 border-orange-400/20
                                    @elseif($request->payment_status === 'reembolsado') bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @endif">
                                    {{ $paymentStatusText }}
                                </span>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Mecánico
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $request->mechanic->name ?? 'Sin asignar' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Monto
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    S/. {{ number_format($request->amount ?? 0, 2) }}
                                </p>
                            </div>

                        </div>

                        <div class="xl:w-40">
                            <a href="{{ route('admin.service-requests.show', $request) }}"
                               class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 px-5 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                <x-admin.icon-eye />
                                Ver detalle
                            </a>
                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-16 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 mb-4">
                        <x-admin.icon-clipboard />
                    </div>

                    <p class="text-white font-bold text-lg">
                        No existen solicitudes registradas
                    </p>

                    <p class="text-slate-300 mt-1">
                        Las solicitudes aparecerán aquí cuando los clientes registren un mantenimiento.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-4 text-white border-t border-cyan-400/10">
            {{ $requests->links() }}
        </div>

    </div>

</div>

@endsection