<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (isset($link))
        <meta name="title" content="{{ $link->title }}">
        <meta name="description" content="{{ $link->deskripsi }}">
        <meta property="og:title" content="{{ $link->title }}">
        <meta property="og:description" content="{{ $link->deskripsi }}">
    @endif

    <title>redirect - {{ env('APP_NAME') . env('APP_DOMAIN') }}</title>
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.7.1-web/css/all.min.css') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="{{ asset('swiper-11.1.15/package/swiper-bundle.min.js') }}"></script>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- @include('layouts.navbar') --}}
    <main class="w-full h-screen bg-gray-200 flex flex-col gap-2 md:gap-4 items-center justify-center p-6">

        <div class="flex flex-col md:flex-row items-center gap-5 md:gap-8 text-gray-700">
            {{-- <div class="rounded-full h-20 w-20 bg-blue-500 flex items-center justify-center">
                <i class="fa-solid fa-link text-5xl text-white"></i>
            </div> --}}
            <img src="{{ asset('logosier.png') }}" alt="Logo SIER" class="w-24 h-36">
            <h1 class="text-5xl md:text-6xl font-semibold ">{{ ENV('APP_NAME') }}</h1>
        </div>
        <p class="text-center">You are being redirected to <a href="{{ $original_url }}"
                class="text-blue-600 hover:underline">{{ $original_url }}</a></p>

    </main>
    {{-- @include('layouts.footer') --}}
    <script>
        const btnPassphrase = document.getElementById('toggle-passphrase');

        btnPassphrase.addEventListener('click', function() {
            const inputPassphrase = document.getElementById('passphrase');
            if (inputPassphrase.type === 'password') {
                inputPassphrase.type = 'text';
                btnPassphrase.classList.remove('fa-eye');
                btnPassphrase.classList.add('fa-eye-slash');
            } else {
                inputPassphrase.type = 'password';
                btnPassphrase.classList.remove('fa-eye-slash');
                btnPassphrase.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>


<script>
    setTimeout(function() {
        window.location.href = "{{ $original_url }}";
    }, 2000);
</script>
