@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    <div class="text-center">

        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Módulo administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Registrar tipo de vehículo
        </h1>

        <p class="text-slate-300 mt-2">
            Registre un nuevo tipo de vehículo para que pueda ser seleccionado por los clientes al registrar sus vehículos.
        </p>

    </div>

    @if($errors->any())

        <div class="rounded-2xl bg-red-500/10 border border-red-400/20 p-5">

            <ul class="list-disc list-inside text-red-300 space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">

        <form action="{{ route('admin.vehicle-types.store') }}"
              method="POST">

            @include('admin.vehicle-types.form')

        </form>

    </div>

</div>

@endsection