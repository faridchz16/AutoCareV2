@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div>
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Módulo administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Editar sede
        </h1>

        <p class="text-slate-300 mt-2">
            Actualice la información registrada de la sede o taller.
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.workshops.update', $workshop) }}"
          class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 p-8 shadow-xl space-y-8">

        @csrf
        @method('PUT')

        @include('admin.workshops.form')

        <div class="flex flex-col md:flex-row gap-4 justify-end">

            <a href="{{ route('admin.workshops.index') }}"
               class="rounded-2xl bg-slate-700 px-6 py-3 text-white font-semibold text-center hover:bg-slate-600 transition">
                Cancelar
            </a>

            <button type="submit"
                    class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-white font-bold hover:scale-105 transition">
                Actualizar sede
            </button>

        </div>

    </form>

</div>

@endsection