@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div>
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Módulo administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Registrar nueva sede
        </h1>

        <p class="text-slate-300 mt-2">
            Complete los datos de la sede o taller donde se atenderán los servicios vehiculares.
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.workshops.store') }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl space-y-8">

        @csrf

        @include('admin.workshops.form')

        <div class="flex flex-col md:flex-row gap-4 justify-end">

            <a href="{{ route('admin.workshops.index') }}"
               class="rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
                Cancelar
            </a>

            <button type="submit"
                    class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
                Guardar sede
            </button>

        </div>

    </form>

</div>

@endsection