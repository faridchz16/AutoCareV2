<aside class="sticky top-0 h-screen w-80 shrink-0 bg-[#031426]/95 border-r border-cyan-900/40 hidden lg:flex flex-col px-7 py-7 overflow-y-auto">

    <div class="text-center">
        <img src="{{ asset('images/autocare/logo.png') }}"
             class="w-40 h-40 object-contain mx-auto mb-4"
             alt="AutoCare">

        <h1 class="text-3xl font-extrabold tracking-wide">AUTOCARE</h1>

        <p class="text-cyan-400 font-semibold text-sm">PANEL CLIENTE</p>
    </div>

    <div class="mt-10 mb-5">
        <p class="text-xs uppercase tracking-[0.30em] text-cyan-400 font-bold">
            Navegación
        </p>
    </div>

    <nav class="flex-1 space-y-4 text-base font-semibold">

        <a href="{{ route('client.dashboard') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('client.dashboard')
                        ? 'bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-cyan-500/10 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl leading-none flex items-center justify-center">⌂</span>
            <span>Inicio</span>
        </a>

        <a href="{{ route('client.vehicles.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('client.vehicles.*')
                        ? 'bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-cyan-500/10 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl leading-none flex items-center justify-center">◉</span>
            <span>Mis vehículos</span>
        </a>

        <a href="{{ route('client.service-requests.create') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('client.service-requests.create')
                        ? 'bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-cyan-500/10 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl leading-none flex items-center justify-center">⌕</span>
            <span>Solicitar mantenimiento</span>
        </a>

        <a href="{{ route('client.service-requests.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('client.service-requests.index') || request()->routeIs('client.service-requests.show')
                        ? 'bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-cyan-500/10 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl leading-none flex items-center justify-center">☷</span>
            <span>Mis solicitudes</span>
        </a>

        <a href="{{ route('client.payments.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('client.payments.*')
                        ? 'bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-cyan-500/10 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl leading-none flex items-center justify-center">◈</span>
            <span>Mis pagos</span>
        </a>

    </nav>

    <div class="mt-auto border-t border-white/10 pt-6">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="w-full flex items-center gap-4  rounded-2xl px-6 py-4 text-red-400 font-semibold hover:bg-red-500/10 transition">

                <span class="w-6 h-6 shrink-0 flex items-center justify-center [&>svg]:!w-6 [&>svg]:!h-6">
                    <x-client.icon-logout />
                </span>

                <span>Cerrar sesión</span>
            </button>

        </form>

    </div>

</aside>