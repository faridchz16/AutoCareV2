<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AutoCare | Panel Administrativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#031020] text-white">

<div class="min-h-screen flex bg-gradient-to-br from-[#031020] via-[#071f3f] to-[#031020]">

    @include('admin.partials.sidebar')

    <main class="flex-1 min-h-screen">
        @include('admin.partials.navbar')

        <section class="px-8 py-7">
            @yield('content')
        </section>

        @include('admin.partials.footer')
    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('form[data-confirm]').forEach(function (form) {

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: form.dataset.confirm || '¿Desea guardar los cambios?',
                    text: 'Verifique que la información ingresada sea correcta.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#06b6d4',
                    cancelButtonColor: '#ef4444',
                    background: '#132b49',
                    color: '#ffffff'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });

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

    });
</script>

</body>
</html>