<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AutoCare | Panel Administrativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#061a33] text-white">

<div class="min-h-screen flex bg-gradient-to-br from-[#061a33] via-[#0b2a52] to-[#031020]">

    <aside class="w-72 bg-[#031426]/95 border-r border-cyan-900/40 hidden lg:flex flex-col px-6 py-6">
        <div class="text-center mb-8">
            <img src="{{ asset('images/autocare/logo.png') }}"
                 class="w-36 h-36 object-contain mx-auto mb-4"
                 alt="AutoCare">

            <h1 class="text-3xl font-extrabold tracking-wide">AUTOCARE</h1>
            <p class="text-cyan-400 font-semibold text-sm">SERVICIO MECÁNICO</p>
        </div>

        <nav class="space-y-3 text-sm font-semibold">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-xl px-5 py-3 transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 shadow-lg shadow-blue-900/40' : 'text-slate-200 hover:bg-blue-600' }}">
                <x-admin.icon-dashboard /> Dashboard
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="flex items-center gap-3 rounded-xl px-5 py-3 transition
                      {{ request()->routeIs('admin.services.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/40' : 'text-slate-200 hover:bg-blue-600' }}">
                <x-admin.icon-tool /> Servicios
            </a>

            <a href="{{ route('admin.service-dates.index') }}"
               class="flex items-center gap-3 rounded-xl px-5 py-3 transition
                      {{ request()->routeIs('admin.service-dates.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/40' : 'text-slate-200 hover:bg-blue-600' }}">
                <x-admin.icon-calendar /> Fechas disponibles
            </a>

            <a href="{{ route('admin.payment-methods.index') }}"
               class="flex items-center gap-3 rounded-xl px-5 py-3 transition
                      {{ request()->routeIs('admin.payment-methods.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/40' : 'text-slate-200 hover:bg-blue-600' }}">
                <x-admin.icon-card /> Formas de pago
            </a>

            <a href="{{ route('admin.service-requests.index') }}"
               class="flex items-center gap-3 rounded-xl px-5 py-3 transition
                      {{ request()->routeIs('admin.service-requests.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/40' : 'text-slate-200 hover:bg-blue-600' }}">
                <x-admin.icon-clipboard /> Solicitudes de atención
            </a>
        </nav>

        <div class="mt-auto border-t border-white/10 pt-5 space-y-3">
            <form method="POST" action="{{ route('logout') }}" data-no-confirm>
                @csrf
                <button type="submit"
                        class="w-full text-left flex items-center gap-3 rounded-xl px-5 py-3 text-red-400 hover:bg-red-500/10 transition">
                    <x-admin.icon-logout /> Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1">
        <header class="h-20 bg-white/5 backdrop-blur border-b border-white/10 flex items-center justify-between px-8">
            <div>
                <h2 class="text-2xl font-bold text-white">AutoCare</h2>
                <p class="text-sm text-slate-300">Panel Administrativo</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-slate-300">Administrador</p>
                </div>

                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center font-bold shadow-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <section class="p-8">
            @yield('content')
        </section>
    </main>

</div>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Operación exitosa',
            text: "{{ session('success') }}",
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#06b6d4',
            background: '#132b49',
            color: '#ffffff'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Ocurrió un problema',
            text: "{{ session('error') }}",
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#ef4444',
            background: '#132b49',
            color: '#ffffff'
        });
    @endif

    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('form');

        forms.forEach(function (form) {
            if (form.hasAttribute('data-no-confirm')) {
                return;
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: '¿Desea guardar los cambios?',
                    text: 'Verifique que la información ingresada sea correcta.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#06b6d4',
                    cancelButtonColor: '#64748b',
                    background: '#132b49',
                    color: '#ffffff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

</body>
</html>