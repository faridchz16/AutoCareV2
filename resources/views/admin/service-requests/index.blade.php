@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div>
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Centro administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Solicitudes de atención
        </h1>

        <p class="text-slate-300 mt-2">
            Supervise las solicitudes registradas por los clientes, asigne mecánicos, valide pagos y controle el estado del servicio.
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
            <h2 class="text-5xl font-extrabold text-white mt-2">{{ $totalRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Pendientes</p>
            <h2 class="text-5xl font-extrabold text-cyan-300 mt-2">{{ $pendingRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">En proceso</p>
            <h2 class="text-5xl font-extrabold text-sky-300 mt-2">{{ $processRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Listas para recoger</p>
            <h2 class="text-5xl font-extrabold text-teal-300 mt-2">{{ $readyRequests }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Pagos pendientes</p>
            <h2 class="text-5xl font-extrabold text-blue-300 mt-2">{{ $pendingPayments }}</h2>
        </div>

    </div>

    <form method="GET"
          action="{{ route('admin.service-requests.index') }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl grid grid-cols-1 xl:grid-cols-5 gap-4">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Buscar cliente, placa, vehículo o servicio..."
               class="xl:col-span-2 rounded-2xl bg-[#0c223d] border border-cyan-500/20 text-white placeholder-slate-400 px-5 py-3 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500">

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
                    class="flex-1 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
                Buscar
            </button>

            <a href="{{ route('admin.service-requests.index') }}"
               class="flex-1 rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
                Limpiar
            </a>
        </div>

    </form>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-cyan-400/10">
            <h2 class="text-xl font-bold text-white">
                Atenciones registradas
            </h2>

            <p class="text-sm text-slate-300 mt-1"></p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px]">
                <thead class="bg-[#061a33] text-cyan-300">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Cliente</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Vehículo</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Servicio</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Fecha y hora</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Forma de pago</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Estado del pago</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Mecánico</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Estado del servicio</th>
                        <th class="px-6 py-4 text-right text-sm font-bold">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cyan-400/10">
                    @forelse($requests as $request)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4 font-semibold text-white">
                                {{ $request->customer->name ?? 'Cliente no disponible' }}
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $request->vehicle_brand }} {{ $request->vehicle_model }}
                                <span class="block text-sm text-slate-400">
                                    Placa: {{ $request->vehicle_plate }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $request->serviceType->name ?? 'Servicio no disponible' }}
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                @if($request->serviceDate)
                                    {{ \Carbon\Carbon::parse($request->serviceDate->available_date)->format('d/m/Y') }}
                                    <span class="block text-sm text-slate-400">
                                        {{ substr($request->serviceDate->start_time, 0, 5) }} - {{ substr($request->serviceDate->end_time, 0, 5) }}
                                    </span>
                                @else
                                    Fecha no disponible
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $request->paymentMethod->name ?? 'No registrada' }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $paymentStatusText = [
                                        'pendiente' => 'Pendiente',
                                        'pagado' => 'Pagado',
                                        'validado' => 'Validado',
                                        'observado' => 'Observado',
                                        'reembolsado' => 'Reembolsado',
                                    ][$request->payment_status ?? 'pendiente'] ?? 'Pendiente';
                                @endphp

                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                    @if(($request->payment_status ?? 'pendiente') === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @elseif($request->payment_status === 'pagado') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->payment_status === 'validado') bg-teal-500/10 text-teal-300 border-teal-400/20
                                    @elseif($request->payment_status === 'observado') bg-orange-500/10 text-orange-300 border-orange-400/20
                                    @elseif($request->payment_status === 'reembolsado') bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @endif">
                                    {{ $paymentStatusText }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $request->mechanic->name ?? 'Sin asignar' }}
                            </td>

                            <td class="px-6 py-4">
                                @php
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

                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
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
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.service-requests.show', $request) }}"
                                   class="rounded-xl bg-cyan-500/10 px-4 py-2 text-cyan-300 font-semibold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center text-slate-300">
                                Aún no existen solicitudes de atención registradas. Las solicitudes aparecerán aquí cuando los clientes soliciten un mantenimiento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 text-white">
            {{ $requests->links() }}
        </div>
    </div>

</div>

@endsection

