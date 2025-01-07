<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.7.1-web/css/all.min.css')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navbar')
    <main class="w-full">
        <section
            class="w-full relative z-10 md:h-screen flex items-center justify-center bg-gradient-to-r from-blue-800 to bg-blue-700 md:mt-[-80px] px-4 overflow-hidden">
            <div class="w-full  max-w-7xl mx-auto grid md:grid-cols-2">
                <div class="w-full flex justify-center flex-col">
                    <h1 class="text-5xl font-bold text-white mb-2 z-40">Welcome to SIER Short Link</h1>
                    <p class="text-white  text-3xl mb-6">The Smart Way to Simplify <span class="underline">Your
                            Digital
                            Connections!</span>
                    </p>
                    <div class="flex gap-8 mb-12">
                        <div class="space-y-2 ">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Generate short link</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Custom Short URLs</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Generate QR Code</p>
                            </div>
                        </div>
                        <div class="space-y-2 mb-6">

                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Expiration Date for Links</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Analytics Dashboard</p>
                            </div>
                        </div>
                    </div>
                    <a href="/"
                        class="bg-orange-500 text-white text-lg py-3 px-9 rounded-lg hover:bg-orange-400  transition w-fit font-bold">
                        Short Your Link
                    </a>
                </div>
                <div class="flex items-center justify-end">
                    <img src="{{ asset('image_landingpage.png') }}" class="w-[550px] z-40" alt="image landingpage">
                </div>
            </div>
            <i class="fa-solid fa-certificate text-blue-300 opacity-20 text-9xl absolute top-[6rem] left-16"></i>
            <div
                class="w-[40rem] h-[40rem] bg-gradient-to-tr from-blue-100/5 to-blue-500 rounded-full absolute -bottom-[8rem] -right-[8rem] opacity-20">
            </div>
        </section>
        <section class="w-full  bg-gray-100 py-20 px-4">
            <div class="w-full max-w-4xl mx-auto text-center mb-10 md:mb-20">
                <h1 class="text-4xl font-bold text-center">Learn about the features that help your digital
                    connection!</h1>
            </div>
            <div class="w-full max-w-4xl mx-auto flex flex-col gap-4 md:gap-10">
                <div class="w-full  grid md:grid-cols-2  bg-white p-10 rounded-lg shadow-lg">
                    <div class="space-y-4">
                        <h1 class="text-3xl font-bold">01. Generate Short Link</h1>
                        <p>Create short, shareable links in seconds. Enhance your long URLs with one click, and share
                            them anywhere to increase engagement. Personalize links as needed and ensure your links
                            always look professional.</p>
                    </div>
                    <div class="flex justify-end">
                        <img src="{{ asset('shortlink_ilsutration.svg') }}" alt="" class="w-[18rem]">
                    </div>
                </div>
                <div class="w-full  grid md:grid-cols-2  bg-white p-10 rounded-lg shadow-lg">
                    <div class="flex justify-start">
                        <img src="{{ asset('qrcodegenerate_ilustration.svg') }}" alt="" class="w-[18rem]">
                    </div>
                    <div class="space-y-4">
                        <h1 class="text-3xl font-bold">02. Generate QR Code</h1>
                        <p>Create instant QR codes from your links for easy access and sharing. Just enter a URL, and
                            we'll generate a QR code ready to use in print, presentations, or events. Fast and practical
                            access, anytime and anywhere.</p>
                    </div>

                </div>
                <div class="w-full  grid md:grid-cols-2  bg-white p-10 rounded-lg shadow-lg">
                    <div class="space-y-4">
                        <h1 class="text-3xl font-bold">03. Analytics Dashboard</h1>
                        <p>Monitor the performance of each link with our Analytics Dashboard. Get real-time insights
                            into the number of clicks, user location, devices used, and access times. Improve your
                            strategy with in-depth, easy-to-understand data.</p>
                    </div>
                    <div class="flex justify-end">
                        <img src="{{ asset('dashboardanalytics_ilustration.svg') }}" alt="" class="w-[20rem]">
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full bg-white py-20">
            <div class="w-full max-w-5xl mx-auto flex flex-col items-center">
                <h1 class="text-center text-4xl font-bold mb-20">How It Works?</h1>
                <div class="grid grid-cols-3 items-center">
                    <div class="w-[]">
                        <img src="{{ asset('Tablet login-amico.svg') }}" alt="" class="w-[20rem]">
                    </div>
                    <div class="flex items-center justify-center">
                        <h1 class="text-8xl font-[800] text-yellow-500">01.</h1>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold mb-4">Login</h1>
                        <p class="text-lg">Login to your account using your email and password.</p>
                    </div>
                </div>
                <div class="flex items-center justify-center flex-col gap-9 mb-10">
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                </div>
                <div class="grid grid-cols-3 items-center">
                    <div>
                        <h1 class="text-3xl font-extrabold mb-4">Create New Short Link</h1>
                        <p class="text-lg">You enter the link of your 'long' product or article to shorten it, then
                            customize it to make it simple and easy to remember. Then, you can easily and quickly share
                            your shortened link.</p>
                    </div>

                    <div class="flex items-center justify-center">
                        <h1 class="text-8xl font-[800] text-yellow-500">02.</h1>
                    </div>
                    <div class="w-[]">
                        <img src="{{ asset('yourshortlink_ilustrator.svg') }}" alt="" class="w-[30rem]">
                    </div>
                </div>
                <div class="flex items-center justify-center flex-col gap-9 mt-10">
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                </div>
                <div class="grid grid-cols-3 items-center">
                    <div class="w-[]">
                        <img src="{{ asset('QR Code-amico.svg') }}" alt="" class="w-[20rem]">
                    </div>
                    <div class="flex items-center justify-center">
                        <h1 class="text-8xl font-[800] text-yellow-500">03.</h1>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold mb-4">Share a short link or download a QR code.</h1>
                        <p class="text-lg">Easily share short links or download QR codes for faster access. A practical
                            option for sharing information across digital platforms or print media.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full h-screen py-20">
            <div class="w-full max-w-2xl mx-auto">
                <h1 class="mb-20 text-4xl font-bold text-center">What do our users say about SIER Short Link?</h1>
                <div>
                    <div class="border flex justify-center">
                        <div class="w-40 h-40 overflow-hidden object-center rounded-full">
                            <img src="{{ asset('person/person1.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('layouts.footer')
</body>

</html>
