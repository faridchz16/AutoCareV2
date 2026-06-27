@extends('client.layouts.app')

@section('content')

<div class="space-y-10">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">

        <div class="flex items-center justify-between w-full gap-8">

            <div class="max-w-3xl">
                <p class="text-cyan-400 font-bold uppercase tracking-widest">
                    Centro del cliente
                </p>

                <h1 class="text-4xl font-extrabold text-white mt-2">
                    Mis solicitudes
                </h1>

                <p class="text-slate-300 mt-2">
                    Consulte el estado de sus solicitudes de mantenimiento vehicular.
                </p>
            </div>

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
                Solicitudes registradas
            </h2>

            <p class="text-slate-300 mt-1">
                Aquí podrá revisar el avance de cada mantenimiento solicitado.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px]">
                <thead class="bg-[#061a33] text-cyan-300">
                    <tr>
                        <th class="px-6 py-4 text-left">Vehículo</th>
                        <th class="px-6 py-4 text-left">Servicio</th>
                        <th class="px-6 py-4 text-left">Fecha y hora</th>
                        <th class="px-6 py-4 text-left">Forma de pago</th>
                        <th class="px-6 py-4 text-left">Estado del pago</th>
                        <th class="px-6 py-4 text-left">Estado del servicio</th>
                        <th class="px-6 py-4 text-center">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cyan-400/10">

                    @forelse($requests as $request)

                        <tr class="hover:bg-white/5 transition">

                            <td class="px-6 py-5 text-white font-semibold">
                                {{ $request->vehicle_brand }} {{ $request->vehicle_model }}

                                <span class="block text-sm text-slate-400 mt-1">
                                    Placa: {{ $request->vehicle_plate }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $request->serviceType->name ?? 'Servicio no disponible' }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                @if($request->serviceDate)
                                    {{ \Carbon\Carbon::parse($request->serviceDate->available_date)->format('d/m/Y') }}

                                    <span class="block text-sm text-slate-400 mt-1">
                                        {{ substr($request->serviceDate->start_time, 0, 5) }} - {{ substr($request->serviceDate->end_time, 0, 5) }}
                                    </span>
                                @else
                                    Fecha no disponible
                                @endif
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $request->paymentMethod->name ?? 'No registrada' }}
                            </td>

                            <td class="px-6 py-5">
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                    @if($request->payment_status === 'pagado') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->payment_status === 'validado') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($request->payment_status === 'observado') bg-yellow-500/10 text-yellow-300 border-yellow-400/20
                                    @elseif($request->payment_status === 'reembolsado') bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @else bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @endif">
                                    {{ ucfirst($request->payment_status ?? 'pendiente') }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold border
                                    @if($request->status === 'pendiente') bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @elseif($request->status === 'confirmado') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->status === 'en_taller') bg-sky-500/10 text-sky-300 border-sky-400/20
                                    @elseif($request->status === 'en_proceso') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->status === 'finalizado_mecanico') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($request->status === 'validado_administrador') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($request->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($request->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                    @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('client.service-requests.show', $request) }}"
                                   class="rounded-xl bg-cyan-500/10 border border-cyan-400/20 px-4 py-2 text-cyan-300 font-semibold hover:bg-cyan-500 hover:text-white transition">
                                    Ver detalle
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-300">
                                Aún no tiene solicitudes registradas. Presione “Solicitar mantenimiento” para comenzar.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="px-6 py-5">
            {{ $requests->links() }}
        </div>

    </section>

</div>

@endsection