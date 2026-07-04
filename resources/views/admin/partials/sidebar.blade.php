<aside class="sticky top-0 h-screen w-80 shrink-0 bg-[#031426]/95 border-r border-cyan-900/40 hidden lg:flex flex-col px-7 py-7 overflow-y-auto">

    <div class="text-center">
        <img src="{{ asset('images/autocare/logo.png') }}"
             class="w-40 h-40 object-contain mx-auto mb-4"
             alt="AutoCare">

        <h1 class="text-3xl font-extrabold tracking-wide">
            AUTOCARE
        </h1>

        <p class="text-cyan-400 font-semibold text-sm">
            PANEL ADMINISTRADOR
        </p>
    </div>

    <div class="mt-10 mb-5">
        <p class="text-xs uppercase tracking-[0.30em] text-cyan-400 font-bold">
            Navegación
        </p>
    </div>

    <nav class="flex-1 space-y-4 text-base font-semibold">

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('admin.dashboard')
                        ? 'bg-gradient-to-r from-blue-600 to-blue-500 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-blue-600/20 hover:text-cyan-300' }}">
            <x-admin.icon-dashboard />
            <span>Inicio</span>
        </a>

        <a href="{{ route('admin.services.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('admin.services.*')
                        ? 'bg-gradient-to-r from-blue-600 to-blue-500 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-blue-600/20 hover:text-cyan-300' }}">
            <x-admin.icon-tool />
            <span>Servicios</span>
        </a>

        <a href="{{ route('admin.service-dates.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('admin.service-dates.*')
                        ? 'bg-gradient-to-r from-blue-600 to-blue-500 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-blue-600/20 hover:text-cyan-300' }}">
            <x-admin.icon-calendar />
            <span>Fechas disponibles</span>
        </a>

        <a href="{{ route('admin.vehicle-types.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('admin.vehicle-types.*')
                        ? 'bg-gradient-to-r from-blue-600 to-blue-500 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-blue-600/20 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl flex items-center justify-center">▣</span>
            <span>Tipos de vehículos</span>
        </a>

        <a href="{{ route('admin.workshops.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('admin.workshops.*')
                        ? 'bg-gradient-to-r from-blue-600 to-blue-500 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-blue-600/20 hover:text-cyan-300' }}">
            <span class="w-6 h-6 text-xl flex items-center justify-center">⌂</span>
            <span>Sedes / Talleres</span>
        </a>

        <a href="{{ route('admin.service-requests.index') }}"
           class="flex items-center gap-4 rounded-2xl px-6 py-4 transition duration-300
                  {{ request()->routeIs('admin.service-requests.*')
                        ? 'bg-gradient-to-r from-blue-600 to-blue-500 shadow-xl shadow-blue-900/40 text-white'
                        : 'text-slate-200 hover:bg-blue-600/20 hover:text-cyan-300' }}">
            <x-admin.icon-clipboard />
            <span>Solicitudes de atención</span>
        </a>

    </nav>

    <div class="border-t border-white/10 pt-6">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="w-full flex items-center gap-4 rounded-2xl px-6 py-4 text-red-400 font-semibold hover:bg-red-500/10 transition">
                <x-admin.icon-logout />
                <span>Cerrar sesión</span>
            </button>
        </form>

    </div>

</aside>