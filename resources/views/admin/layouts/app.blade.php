<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel Administrativo | AutoCare</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#031020] text-white">

<div class="min-h-screen flex bg-gradient-to-br from-[#031020] via-[#071f3f] to-[#031020]">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <div class="flex-1 min-h-screen flex flex-col overflow-x-hidden">

        {{-- NAVBAR --}}
        @include('admin.partials.navbar')

        <main class="flex-1 px-8 py-7">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('admin.partials.footer')

    </div>

</div>

</body>
</html>