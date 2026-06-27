@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

    <div class="text-center">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Módulo administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Nuevo servicio
        </h1>

        <p class="text-slate-300 mt-2">
            Registre un servicio vehicular que luego podrá ser seleccionado por los clientes.
        </p>
    </div>

    @if(session('error'))
        <div class="rounded-2xl bg-red-500/10 border border-red-500/30 px-5 py-4 text-red-300 text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">

        <form action="{{ route('admin.services.store') }}"
              method="POST"
              data-confirm="¿Desea registrar este servicio?">

            @include('admin.services.form')

        </form>

    </div>

</div>

@endsection

