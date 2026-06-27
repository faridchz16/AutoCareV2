@extends('layouts.admin')

@section('content')

<div class="rounded-3xl overflow-hidden border border-cyan-400/20 shadow-2xl mb-8">
    <div class="relative p-10 bg-cover bg-center"
         style="background-image: linear-gradient(90deg, rgba(3,16,32,.98), rgba(3,16,32,.84), rgba(3,16,32,.35)), url('{{ asset('images/autocare/admin-bg.png') }}');">

        <p class="text-cyan-400 font-bold uppercase tracking-wide">
            AutoCare - Panel Administrativo
        </p>

        <h1 class="text-5xl font-extrabold mt-4 text-white">
            Bienvenido, {{ auth()->user()->name }}
        </h1>

        <p class="text-slate-200 mt-4 max-w-3xl text-lg">
            Desde este panel puedes gestionar servicios, fechas disponibles, formas de pago y supervisar las solicitudes de atención vehicular.
        </p>

        <div class="flex flex-wrap gap-4 mt-8">
            <a href="{{ route('admin.services.index') }}"
               class="flex items-center gap-3 rounded-xl bg-blue-600 px-7 py-4 font-bold hover:bg-blue-700 transition">
                <x-admin.icon-tool /> Servicios
            </a>

            <a href="{{ route('admin.service-dates.index') }}"
               class="flex items-center gap-3 rounded-xl bg-green-600 px-7 py-4 font-bold hover:bg-green-700 transition">
                <x-admin.icon-calendar /> Fechas
            </a>

            <a href="{{ route('admin.payment-methods.index') }}"
               class="flex items-center gap-3 rounded-xl bg-cyan-600 px-7 py-4 font-bold hover:bg-cyan-700 transition">
                <x-admin.icon-card /> Formas de pago
            </a>

            <a href="{{ route('admin.service-requests.index') }}"
               class="flex items-center gap-3 rounded-xl bg-yellow-500 px-7 py-4 font-bold text-slate-900 hover:bg-yellow-400 transition">
                <x-admin.icon-clipboard /> Solicitudes
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-xl text-white">
        <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center mb-4">
            <x-admin.icon-tool />
        </div>
        <p class="text-slate-300">Servicios registrados</p>
        <h2 class="text-5xl font-extrabold mt-2">{{ $totalServices }}</h2>
        <p class="text-green-400 mt-2">{{ $activeServices }} activos</p>
    </div>

    <div class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-xl text-white">
        <div class="w-16 h-16 rounded-2xl bg-green-600 flex items-center justify-center mb-4">
            <x-admin.icon-calendar />
        </div>
        <p class="text-slate-300">Fechas disponibles</p>
        <h2 class="text-5xl font-extrabold mt-2">{{ $availableDates }}</h2>
        <p class="text-red-400 mt-2">{{ $blockedDates }} bloqueadas</p>
    </div>

    <div class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-xl text-white">
        <div class="w-16 h-16 rounded-2xl bg-yellow-500 text-slate-900 flex items-center justify-center mb-4">
            <x-admin.icon-clipboard />
        </div>
        <p class="text-slate-300">Solicitudes pendientes</p>
        <h2 class="text-5xl font-extrabold mt-2">{{ $pendingRequests }}</h2>
        <p class="text-blue-400 mt-2">{{ $processRequests }} en proceso</p>
    </div>

    <div class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-xl text-white">
        <div class="w-16 h-16 rounded-2xl bg-purple-600 flex items-center justify-center mb-4">
            <x-admin.icon-user />
        </div>
        <p class="text-slate-300">Mecánicos activos</p>
        <h2 class="text-5xl font-extrabold mt-2">{{ $activeMechanics }}</h2>
        <p class="text-slate-300 mt-2">{{ $paymentMethods }} formas de pago activas</p>
    </div>
</div>

<div class="rounded-3xl bg-white/10 border border-white/10 shadow-xl p-8">
    <h2 class="text-2xl font-bold text-white mb-6">Accesos rápidos</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <a href="{{ route('admin.services.index') }}" class="rounded-2xl border border-white/10 bg-[#082344]/80 p-6 hover:bg-[#0b315f] transition">
            <div class="w-14 h-14 rounded-xl bg-blue-600 flex items-center justify-center mb-4">
                <x-admin.icon-tool />
            </div>
            <h3 class="text-xl font-bold text-white">Gestionar servicios</h3>
            <p class="text-slate-300 mt-3">Administre los servicios disponibles para los clientes.</p>
            <p class="text-blue-400 font-bold mt-6">Ingresar →</p>
        </a>

        <a href="{{ route('admin.service-dates.index') }}" class="rounded-2xl border border-white/10 bg-[#082344]/80 p-6 hover:bg-[#0b315f] transition">
            <div class="w-14 h-14 rounded-xl bg-green-600 flex items-center justify-center mb-4">
                <x-admin.icon-calendar />
            </div>
            <h3 class="text-xl font-bold text-white">Controlar fechas</h3>
            <p class="text-slate-300 mt-3">Habilite o bloquee horarios de atención.</p>
            <p class="text-green-400 font-bold mt-6">Ingresar →</p>
        </a>

        <a href="{{ route('admin.payment-methods.index') }}" class="rounded-2xl border border-white/10 bg-[#082344]/80 p-6 hover:bg-[#0b315f] transition">
            <div class="w-14 h-14 rounded-xl bg-cyan-600 flex items-center justify-center mb-4">
                <x-admin.icon-card />
            </div>
            <h3 class="text-xl font-bold text-white">Formas de pago</h3>
            <p class="text-slate-300 mt-3">Configure Mercado Pago u otras opciones activas.</p>
            <p class="text-cyan-400 font-bold mt-6">Ingresar →</p>
        </a>

        <a href="{{ route('admin.service-requests.index') }}" class="rounded-2xl border border-white/10 bg-[#082344]/80 p-6 hover:bg-[#0b315f] transition">
            <div class="w-14 h-14 rounded-xl bg-yellow-500 text-slate-900 flex items-center justify-center mb-4">
                <x-admin.icon-clipboard />
            </div>
            <h3 class="text-xl font-bold text-white">Solicitudes</h3>
            <p class="text-slate-300 mt-3">Revise atenciones, asigne mecánicos y confirme servicios listos.</p>
            <p class="text-yellow-400 font-bold mt-6">Ingresar →</p>
        </a>

    </div>
</div>

<footer class="mt-8 flex justify-between text-sm text-slate-300">
    <p>© 2026 AutoCare - Team Mecánico. Todos los derechos reservados.</p>
    <p>Versión 1.0.0</p>
</footer>

@endsection