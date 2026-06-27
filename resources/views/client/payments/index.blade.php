@extends('client.layouts.app')

@section('content')

<div class="space-y-7">

    <section class="rounded-[32px] bg-[#132b49]/80 border border-cyan-400/10 shadow-xl px-8 py-7">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-cyan-400 font-bold uppercase tracking-widest">
                    Centro del cliente
                </p>

                <h1 class="text-4xl font-extrabold text-white mt-2">
                    Mis pagos
                </h1>

                <p class="text-slate-300 mt-2">
                    Consulte los pagos pendientes y realice el pago de sus servicios de mantenimiento.
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
                Pagos registrados
            </h2>

            <p class="text-slate-300 mt-1">
                Aquí podrá consultar el costo del servicio y realizar el pago correspondiente.
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-[#061a33]">

                    <tr>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Servicio
                        </th>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Método de pago
                        </th>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Monto
                        </th>

                        <th class="px-6 py-4 text-left text-cyan-300">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center text-cyan-300">
                            Acción
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-cyan-400/10">

                    @forelse($payments as $payment)

                        <tr class="hover:bg-white/5 transition">

                            <td class="px-6 py-5 text-white font-semibold">
                                {{ $payment->serviceType->name }}
                            </td>

                            <td class="px-6 py-5 text-slate-300">
                                {{ $payment->paymentMethod->name }}
                            </td>

                            <td class="px-6 py-5 text-cyan-300 font-bold">
                                S/. {{ number_format($payment->amount,2) }}
                            </td>

                            <td class="px-6 py-5">

                                @if($payment->payment_status == 'pagado')

                                    <span class="rounded-full bg-green-500/10 border border-green-400/20 px-3 py-1 text-green-300 text-sm font-semibold">
                                        Pagado
                                    </span>

                                @else

                                    <span class="rounded-full bg-yellow-500/10 border border-yellow-400/20 px-3 py-1 text-yellow-300 text-sm font-semibold">
                                        Pendiente
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-center">

                                @if($payment->payment_status == 'pendiente')

                                    <form method="POST" action="{{ route('client.payments.pay', $payment) }}">
                                        @csrf

                                        <button type="submit"
                                                class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2 font-bold text-white hover:scale-105 transition">
                                            Pagar
                                        </button>
                                    </form>

                                @else

                                    <span class="text-green-300 font-semibold">
                                        ✔ Completado
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-12 text-center text-slate-300">

                                No tiene pagos registrados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="px-6 py-5">

            {{ $payments->links() }}

        </div>

    </section>

</div>

@endsection