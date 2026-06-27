@extends('client.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    <div>

        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Centro del cliente
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Registrar vehículo
        </h1>

        <p class="text-slate-300 mt-2">
            Complete la información de su vehículo para poder solicitar servicios de mantenimiento.
        </p>

    </div>

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 border border-red-400/20 text-red-300 px-6 py-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">

        <div class="px-8 py-6 border-b border-cyan-400/10">

            <h2 class="text-2xl font-bold text-white">
                Información del vehículo
            </h2>

            <p class="text-slate-300 mt-1">
                Los datos registrados serán utilizados al momento de solicitar un mantenimiento.
            </p>

        </div>

        <div class="p-8">

            <form action="{{ route('client.vehicles.store') }}"
                  method="POST"
                  class="space-y-8">

                @csrf

                @include('client.vehicles.form')

            </form>

        </div>

    </div>

</div>

@endsection