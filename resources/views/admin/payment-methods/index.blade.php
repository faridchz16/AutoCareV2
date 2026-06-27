@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-cyan-400 font-bold uppercase tracking-widest">
                Módulo administrativo
            </p>

            <h1 class="text-4xl font-extrabold text-white mt-2">
                Formas de pago
            </h1>

            <p class="text-slate-300 mt-2">
                Administre las formas de pago disponibles para los clientes.
            </p>
        </div>

        <a href="{{ route('admin.payment-methods.create') }}"
           class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-4 text-white font-bold hover:bg-cyan-600 transition">
            Registrar forma de pago
        </a>
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Total registradas</p>
            <h2 class="text-5xl font-extrabold text-white mt-2">{{ $totalMethods }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Activas</p>
            <h2 class="text-5xl font-extrabold text-cyan-300 mt-2">{{ $activeMethods }}</h2>
        </div>

        <div class="rounded-3xl bg-[#132b49]/90 border border-cyan-400/10 p-6 shadow-xl">
            <p class="text-slate-300">Inactivas</p>
            <h2 class="text-5xl font-extrabold text-red-300 mt-2">{{ $inactiveMethods }}</h2>
        </div>
    </div>

    <div class="rounded-[28px] bg-[#132b49]/90 border border-cyan-400/10 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-cyan-400/10">
            <h2 class="text-xl font-bold text-white">
                Métodos registrados
            </h2>

            <p class="text-sm text-slate-300 mt-1"></p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#061a33] text-cyan-300">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Forma de pago</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Estado</th>
                        <th class="px-6 py-4 text-right text-sm font-bold">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cyan-400/10">
                    @forelse($paymentMethods as $method)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4 font-semibold text-white">
                                {{ $method->name }}
                            </td>

                            <td class="px-6 py-4">
                                @if($method->status === 'activo')
                                    <span class="inline-flex rounded-full bg-cyan-500/10 px-3 py-1 text-sm font-semibold text-cyan-300 border border-cyan-400/20">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-500/10 px-3 py-1 text-sm font-semibold text-red-300 border border-red-400/20">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}"
                                   class="rounded-xl bg-blue-500/10 px-4 py-2 text-blue-300 font-semibold border border-blue-400/20 hover:bg-blue-600 hover:text-white transition">
                                    Editar estado
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-slate-300">
                                No hay formas de pago registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 text-white">
            {{ $paymentMethods->links() }}
        </div>
    </div>

</div>

@endsection