<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel Mecánico | AutoCare</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#031020] text-white overflow-x-hidden">

<div class="flex min-h-screen w-full bg-gradient-to-br from-[#031020] via-[#071f3f] to-[#031020]">

    @include('mechanic.partials.sidebar')

    <div class="flex min-h-screen flex-1 flex-col w-full min-w-0">

        @include('mechanic.partials.navbar')

        <main class="flex-1 w-full px-8 py-7">
            @yield('content')
        </main>

        @include('mechanic.partials.footer')

    </div>

</div>

</body>
</html>