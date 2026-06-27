<header class="h-20 bg-[#0d2444]/90 backdrop-blur border-b border-cyan-900/30 px-8 flex items-center justify-between shadow-lg">

    <div>
        <h2 class="text-4xl font-extrabold text-white">
            AutoCare
        </h2>

        <p class="text-cyan-300 text-sm">
            Panel Administrativo
        </p>
    </div>

    <div class="flex items-center gap-4">

        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center font-bold text-lg shadow-lg">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="leading-tight text-right">
            <h4 class="font-bold text-white">
                {{ auth()->user()->name }}
            </h4>

            <p class="text-cyan-300 text-sm">
                Administrador
            </p>
        </div>

    </div>

</header>