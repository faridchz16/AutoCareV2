@extends('client.layouts.app')

@section('content')

<div class="space-y-10">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
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

            <a href="{{ route('client.service-requests.create') }}"
               class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-4 text-white font-bold hover:bg-cyan-600 transition">
                Nueva solicitud
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
                Solicitudes registradas
            </h2>

            <p class="text-slate-300 mt-1">
                Revise el avance del servicio, la fecha de atención y el estado del pago.
            </p>
        </div>

        <div class="p-6 space-y-5">

            @forelse($requests as $request)

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
                                        @elseif($request->status === 'finalizado_mecanico') bg-green-500/10 text-green-300 border-green-400/20
                                        @elseif($request->status === 'validado_administrador') bg-green-500/10 text-green-300 border-green-400/20
                                        @elseif($request->status === 'listo_para_recoger') bg-green-500/10 text-green-300 border-green-400/20
                                        @elseif($request->status === 'cancelado') bg-red-500/10 text-red-300 border-red-400/20
                                        @else bg-slate-500/10 text-slate-300 border-slate-400/20
                                        @endif">
                                        {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                    </span>
                                </div>

                                <p class="text-slate-300 mt-2">
                                    {{ $request->vehicle_brand }} {{ $request->vehicle_model }}
                                    <span class="text-slate-500">·</span>
                                    Placa: {{ $request->vehicle_plate }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 xl:w-[720px]">

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Fecha y hora
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    @if($request->serviceDate)
                                        {{ \Carbon\Carbon::parse($request->serviceDate->available_date)->format('d/m/Y') }}
                                        <span class="block text-slate-300 text-sm mt-1">
                                            {{ substr($request->serviceDate->start_time, 0, 5) }} - {{ substr($request->serviceDate->end_time, 0, 5) }}
                                        </span>
                                    @else
                                        Fecha no disponible
                                    @endif
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Forma de pago
                                </p>

                                <p class="text-white font-semibold mt-2">
                                    {{ $request->paymentMethod->name ?? 'No registrada' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#0c223d] border border-cyan-400/10 p-4">
                                <p class="text-xs uppercase tracking-widest text-cyan-400 font-bold">
                                    Estado del pago
                                </p>

                                <span class="inline-flex mt-2 rounded-full px-3 py-1 text-sm font-semibold border
                                    @if($request->payment_status === 'pagado') bg-blue-500/10 text-blue-300 border-blue-400/20
                                    @elseif($request->payment_status === 'validado') bg-green-500/10 text-green-300 border-green-400/20
                                    @elseif($request->payment_status === 'observado') bg-yellow-500/10 text-yellow-300 border-yellow-400/20
                                    @elseif($request->payment_status === 'reembolsado') bg-slate-500/10 text-slate-300 border-slate-400/20
                                    @else bg-cyan-500/10 text-cyan-300 border-cyan-400/20
                                    @endif">
                                    {{ ucfirst($request->payment_status ?? 'pendiente') }}
                                </span>
                            </div>

                        </div>

                        <div class="xl:w-40">
                            <a href="{{ route('client.service-requests.show', $request) }}"
                               class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-cyan-500/10 px-5 py-3 text-cyan-300 font-bold border border-cyan-400/20 hover:bg-cyan-500 hover:text-white transition">
                                <x-admin.icon-eye />
                                Ver detalle
                            </a>
                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-14 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-cyan-300 mb-4">
                        <x-admin.icon-tool />
                    </div>

                    <p class="text-white font-bold text-lg">
                        Aún no tiene solicitudes registradas
                    </p>

                    <p class="text-slate-300 mt-1">
                        Presione “Nueva solicitud” para registrar su primer mantenimiento.
                    </p>
                </div>

            @endforelse

        </div>

        <div class="px-6 py-5 border-t border-cyan-400/10">
            {{ $requests->links() }}
        </div>

    </section>

</div>

@endsection