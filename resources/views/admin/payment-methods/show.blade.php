@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

    <div class="text-center">
        <p class="text-cyan-400 font-bold uppercase tracking-widest">
            Módulo administrativo
        </p>

        <h1 class="text-4xl font-extrabold text-white mt-2">
            Detalle de la forma de pago
        </h1>

        <p class="text-slate-300 mt-2">
            Información registrada para esta forma de pago.
        </p>
    </div>

    <div class="rounded-[32px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl p-10">

        <div class="mb-10 text-center">

            <p class="text-cyan-300 font-semibold">
                Forma de pago
            </p>

            <h2 class="text-5xl font-extrabold text-white mt-3">
                {{ $paymentMethod->name }}
            </h2>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 text-center">

            <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 flex flex-col items-center justify-center">

                <p class="text-slate-300">
                    Estado
                </p>

                @if($paymentMethod->status === 'activo')

                    <span class="mt-4 inline-flex rounded-full bg-cyan-500/10 px-5 py-2 text-sm font-bold text-cyan-300 border border-cyan-400/20">
                        Activo
                    </span>

                @else

                    <span class="mt-4 inline-flex rounded-full bg-red-500/10 px-5 py-2 text-sm font-bold text-red-300 border border-red-400/20">
                        Inactivo
                    </span>

                @endif

            </div>

            <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 flex flex-col items-center justify-center">

                <p class="text-slate-300">
                    Uso
                </p>

                <p class="text-2xl font-extrabold text-white mt-3">
                    Disponible para pagos del sistema
                </p>

            </div>

        </div>

        <div class="mb-10 text-center">

            <p class="text-cyan-300 font-semibold mb-4">
                Descripción
            </p>

            <div class="rounded-3xl bg-[#082344]/90 border border-cyan-400/10 p-8 text-slate-300 leading-8 max-w-4xl mx-auto">

                {{ $paymentMethod->description ?: 'No se registró una descripción.' }}

            </div>

        </div>

        <div class="flex justify-center gap-5 flex-wrap">

            <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}"
               class="rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-4 text-white font-bold hover:scale-105 transition">

                Editar forma de pago

            </a>

            <a href="{{ route('admin.payment-methods.index') }}"
               class="rounded-2xl bg-slate-700 px-8 py-4 text-white font-semibold hover:bg-slate-600 transition">

                Ir a formas de pago

            </a>

        </div>

    </div>

</div>

@endsection

