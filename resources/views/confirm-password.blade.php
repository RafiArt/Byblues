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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- @include('layouts.navbar') --}}
    <main class="w-full h-screen md:bg-blue-600 bg-white  flex items-center justify-center">
        <form action="{{ route('confirm-password.redirect', $short_url) }}" method="POST"
            class="w-full max-w-4xl bg-white py-24 px-4 flex flex-col gap-4 md:rounded-xl items-center">
            @csrf
            <div class="flex flex-col gap-2 md:gap-4 items-center text-gray-900">
                <div class="flex items-center text-xl md:text-3xl gap-4">
                    <i class="fa-solid fa-lock"></i>
                    <h1 class="font-extrabold"><span
                            class="text-blue-600">{{ ENV('APP_NAME') }}</span>{{ env('APP_DOMAIN') . '/' . $short_url }}
                    </h1>
                </div>
                <p class="text-sm">Enter Passphrase to continue</p>
            </div>
            <div class="relative">
                <input type="password" name="passphrase" id="passphrase" placeholder="______"
                    class="w-[20rem] border-none bg-gray-100 border-blue-500 py-3 px-4 outline-none rounded-lg focus:border-gray-500 focus:ring-gray-400 focus:ring-2 placeholder:text-gray-400 font-medium"
                    required>
                <i id="toggle-passphrase"
                    class="fa-solid fa-eye absolute top-1/2 right-0 p-4 -translate-y-1/2 text-lg text-gray-500 hover:text-blue-600 transition cursor-pointer"></i>
            </div>
            @if (session('error'))
                <p class="text-center text-sm text-red-500">{{ session('error') }}</p>
            @endif
            <button
                class="w-full max-w-[20rem] rounded-lg py-3 px-4 text-white flex items-center justify-center font-semibold bg-blue-600 hover:bg-blue-700 transition"
                type="submit">Continue</button>
            <p class="text-sm max-w-[40rem] text-center mt-4">This link is generated user content and be carefull for
                phishing/scam/malware.
                We never
                ask for your
                information details. If you received this link within a suspicious email, phone calls, or other
                messages. Please do not go further.</p>
        </form>
    </main>
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
