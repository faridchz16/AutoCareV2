<header class="border-b border-cyan-400/10 bg-[#061a33]/95">

    <div class="flex items-center justify-between px-8 py-5">

        <div>
            <h2 class="text-2xl font-bold text-white">
                Panel del Cliente
            </h2>

            <p class="text-sm text-slate-300 mt-1">
                Bienvenido nuevamente, {{ auth()->user()->name }}
            </p>
        </div>

        <div class="flex items-center gap-5">

            <div class="text-right">
                <p class="text-sm text-slate-400">
                    Usuario
                </p>

                <p class="font-bold text-cyan-300">
                    {{ auth()->user()->name }}
                </p>
            </div>

            <img src="{{ auth()->user()->profile_photo_url }}"
                 alt="{{ auth()->user()->name }}"
                 class="w-12 h-12 rounded-full border-2 border-cyan-400 object-cover">

        </div>

    </div>

</header>