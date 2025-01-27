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
    <main class="w-full flex flex-col min-h-screen pb-10">
        <section
            class="w-full relative z-10 md:h-screen flex items-center justify-center bg-gradient-to-r from-blue-800 to bg-blue-700 md:mt-[-80px] px-4 overflow-hidden">
            <div class="w-full  max-w-7xl mx-auto grid md:grid-cols-2">
                <div class="w-full flex justify-center flex-col">
                    <h1 class="text-5xl font-bold text-white mb-2 z-40">Welcome to BYBLUES</h1>
                    <p class="text-white  text-3xl mb-6">A Smart Solution to <span class="underline">Quickly and Effectively Detecting Baby Blues!</span>
                    </p>
                    <div class="flex gap-8 mb-12">
                        <div class="space-y-2 ">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Diagnosis Babyblues</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Konsultasi Babyblues</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Rekomendasi Penanganan Babyblues</p>
                            </div>
                        </div>
                        {{-- <div class="space-y-2 mb-6">

                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Expiration Date for Links</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check text-green-500 text-lg"></i>
                                <p class="text-white">Analytics Dashboard</p>
                            </div>
                        </div> --}}
                    </div>
                    <a href="/register"
                        class="bg-orange-500 text-white text-lg py-3 px-9 rounded-lg hover:bg-orange-400  transition w-fit font-bold">
                        Get Start
                    </a>
                </div>
                <div class="flex items-center justify-end">
                    <img src="{{ asset('tp.png') }}" class="w-[550px] z-40" alt="image landingpage">
                </div>
            </div>
            <i class="fa-solid fa-certificate text-blue-300 opacity-20 text-9xl absolute top-[6rem] left-16"></i>
            <div
                class="w-[40rem] h-[40rem] bg-gradient-to-tr from-blue-100/5 to-blue-500 rounded-full absolute -bottom-[8rem] -right-[8rem] opacity-20">
            </div>
        </section>
        <section class="w-full  bg-gray-100 py-20 px-4">
            <div class="w-full max-w-4xl mx-auto text-center mb-10 md:mb-20">
                <h1 class="text-4xl font-bold text-center">Learn about the features that help your diagnosis!</h1>
            </div>
            <div class="w-full max-w-4xl mx-auto flex flex-col gap-4 md:gap-10">
                <div class="w-full  grid md:grid-cols-2  bg-white p-10 rounded-lg shadow-lg">
                    <div class="space-y-4">
                        <h1 class="text-3xl font-bold">01. Diagnosis Babyblues</h1>
                        <p>Baby blues diagnosis involves evaluating symptoms like anxiety, irritability, or fatigue after childbirth. It typically lasts a few days to two weeks and is considered normal, but still requires medical attention.</p>
                    </div>
                    <div class="flex justify-end">
                        <img src="{{ asset('1.svg') }}" alt="" class="w-[18rem]">
                    </div>
                </div>
                <div class="w-full  grid md:grid-cols-2  bg-white p-10 rounded-lg shadow-lg">
                    <div class="flex justify-start">
                        <img src="{{ asset('3.svg') }}" alt="" class="w-[18rem]">
                    </div>
                    <div class="space-y-4">
                        <h1 class="text-3xl font-bold">02. Konsultasi Babyblues</h1>
                        <p>A baby blues consultation involves discussing with healthcare professionals such as psychologists. It is essential to receive emotional support, assess the mother's condition, and determine if further treatment is needed.</p>
                    </div>

                </div>
                <div class="w-full  grid md:grid-cols-2  bg-white p-10 rounded-lg shadow-lg">
                    <div class="space-y-4">
                        <h1 class="text-3xl font-bold">03. Rekomendasi Penanganan Babyblues</h1>
                        <p> Managing baby blues includes getting enough rest, having social support from family, and engaging in relaxation activities. If symptoms persist or worsen, therapy or medication from a professional may be necessary to prevent a more serious condition like postpartum depression.</p>
                    </div>
                    <div class="flex justify-end">
                        <img src="{{ asset('2.svg') }}" alt="" class="w-[15rem]">
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
                        <h1 class="text-3xl font-extrabold mb-4">Diagnosa</h1>
                        <p class="text-lg">The Diagnosis Feature helps users assess their emotional well-being after childbirth by asking a series of questions. Users respond with YA, BISA JADI, or TIDAK based on their experiences, and the system evaluates the potential presence and severity of baby blues.</p>
                    </div>

                    <div class="flex items-center justify-center">
                        <h1 class="text-8xl font-[800] text-yellow-500">02.</h1>
                    </div>
                    <div class="w-[]">
                        <img src="{{ asset('stress.svg') }}" alt="" class="w-[30rem]">
                    </div>
                </div>
                <div class="flex items-center justify-center flex-col gap-9 mt-10">
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                </div>
                <div class="grid grid-cols-3 items-center">
                    <div class="w-[]">
                        <img src="{{ asset('doctor.svg') }}" alt="" class="w-[20rem]">
                    </div>
                    <div class="flex items-center justify-center">
                        <h1 class="text-8xl font-[800] text-yellow-500">03.</h1>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold mb-4">Report Analyst</h1>
                        <p class="text-lg">The results are then processed using the Certainty Factor (CF) method in the Report Analysis feature. This method categorizes the user's condition into four levels: Tidak Berisiko, Risiko Rendah, Risiko Sedang, and Risiko Berat. If the analysis indicates Severe Risk, a contact person will be provided, guiding the user to a psychologist for further consultation and support.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full py-20 mb-10" id="berita">
            <div class="w-full max-w-6xl mx-auto">
                <h1 class="mb-20 text-4xl font-bold text-center">Berita Terkini</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach ($news as $article)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col">
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover rounded-t-md">
                            @else
                                <img src="/images/no-image.jpg" alt="No Image" class="w-full h-48 object-cover rounded-t-md">
                            @endif
                            <div class="p-5 flex-1">
                                <h2 class="text-xl font-semibold mb-4">{{ $article->title }}</h2>
                                <p class="text-gray-700 mb-1">{{ Str::limit($article->content, 20) }}</p>
                                <a href="{{ route('news.show', $article->id) }}" class="text-blue-600 hover:underline">Read More</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


    </main>
    @include('layouts.footer')
</body>

</html>
