<aside class="sticky top-0 h-screen w-80 shrink-0 bg-[#031426]/95 border-r border-cyan-900/40 hidden lg:flex flex-col px-7 py-7 overflow-y-auto">

    <div class="text-center">
        <img src="{{ asset('images/autocare/logo.png') }}"
             class="w-40 h-40 object-contain mx-auto mb-4"
             alt="AutoCare">

        <h1 class="text-3xl font-extrabold tracking-wide">
            AUTOCARE
        </h1>

        <p class="text-cyan-400 font-semibold text-sm">
            PANEL MECÁNICO
        </p>
    </div>

    <div class="mt-10 mb-5">
        <p class="text-xs uppercase tracking-[0.30em] text-cyan-400 font-bold">
            Navegación
        </p>
    </div>

    <nav class="flex-1 space-y-4 text-base font-semibold">

        <a href="{{ route('mechanic.dashboard') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('mechanic.dashboard')
                        ? 'bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-cyan-500/10 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl flex items-center justify-center">⌂</span>
            <span>Inicio</span>
        </a>

        <a href="{{ route('mechanic.jobs.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('mechanic.jobs.*')
                        ? 'bg-gradient-to-r from-cyan-500 to-blue-600 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-cyan-500/10 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl flex items-center justify-center">⌕</span>
            <span>Mis trabajos</span>
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