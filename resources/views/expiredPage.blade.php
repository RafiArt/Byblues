<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>protected - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.7.1-web/css/all.min.css') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>

<body>
    <main class="w-full h-screen bg-gray-800  flex items-center justify-center">
        <div class="text-white flex items-center flex-col gap-9">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-hourglass-end text-[7rem] md:text-[10rem]"></i>
                <h1 class="text-7xl md:text-9xl font-extrabold">Oops!</h1>
            </div>
            <p class="text-xl md:text-2xl font-medium">{{ ENV('APP_NAME') . env('APP_DOMAIN') }} | The link has expired
            </p>
        </div>
    </main>
</body>

</html>
