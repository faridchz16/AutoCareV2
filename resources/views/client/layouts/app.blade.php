<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel Cliente | AutoCare</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#031020] text-white">

<div class="flex min-h-screen bg-gradient-to-br from-[#031020] via-[#071f3f] to-[#031020]">

    @include('client.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('client.partials.navbar')

        <main class="flex-1 p-8">
            @yield('content')
        </main>

        @include('client.partials.footer')

    </div>

</div>

</body>
</html>