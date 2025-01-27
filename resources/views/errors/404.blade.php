<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('fontawesome-free-6.7.1-web/css/all.min.css')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>

<body class="flex items-center justify-center h-screen bg-white">
    <div class="text-center">
        <div class="text-9xl font-bold flex items-center justify-center mb-4">
            <img alt="Crying emoji" class="w-1060 h-520 mx-2" src="{{ asset('eror.png') }}"/>
        </div>
        <h1 class="text-2xl font-bold mt-4">
            OOPS! PAGE NOT FOUND
        </h1>
        <p class="text-gray-500 mb-4"> <!-- Increased bottom margin -->
            Sorry but the page you are looking for does not exist!
        </p>
        <a href="{{ url('/dashboard') }}" class="mt-6 px-6 py-2 bg-orange-500 text-white rounded-full"> <!-- Increased top margin -->
            Back to homepage
        </a>
    </div>
</body>
</html>
