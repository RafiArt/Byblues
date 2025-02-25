<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.7.1-web/css/all.min.css')}}" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>


    <!-- Desktop Navigation -->
    <div class="lg:block">
        @include('layouts.navbar')
    </div>

    <main class="w-full flex flex-col min-h-screen pb-10">
        <!-- Hero Section -->
        <section class="w-full relative z-10 lg:h-screen flex items-center justify-center bg-gradient-to-r from-blue-800 to bg-blue-700 lg:mt-[-80px] px-4 py-8 lg:py-0 overflow-hidden">
            <div class="w-full max-w-7xl mx-auto grid lg:grid-cols-2 gap-10 lg:gap-0">
                <div class="w-full flex justify-center flex-col text-center lg:text-left">
                    <h1 class="text-3xl lg:text-5xl font-bold text-white mb-2 z-40">Welcome to BYBLUES</h1>
                    <p class="text-white text-xl lg:text-3xl mb-6">Solusi Cerdas untuk <span class="underline">Mendeteksi Baby Blues dengan Cepat dan Efektif!</span></p>
                    <div class="flex flex-col gap-8 mb-12 lg:ml-0 ml-6 ">
                        <div class="space-y-2">
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
                    </div>
                    <div>
                        <a href="/register" class="bg-orange-500 text-white text-lg py-3 px-9 rounded-lg hover:bg-orange-400 transition w-fit font-bold">
                            Mulai
                        </a>
                    </div>
                </div>
                <div class="flex items-center justify-center lg:justify-end">
                    <img src="{{ asset('tp.png') }}" class="w-[300px] lg:w-[550px] z-40" alt="image landingpage">
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="w-full bg-gray-100 py-20 px-4" id="features">
            <div class="w-full max-w-4xl mx-auto text-center mb-10 lg:mb-20">
                <h1 class="text-2xl lg:text-4xl font-bold">Pelajari tentang fitur yang membantu diagnosis Anda!</h1>
            </div>
            <div class="w-full max-w-4xl mx-auto flex flex-col gap-4 lg:gap-10">
                <!-- Card 1 -->
                <div class="w-full grid lg:grid-cols-2 bg-white p-6 lg:p-10 rounded-lg shadow-lg min-h-[300px]">
                    <div class="space-y-4 flex flex-col justify-center">
                        <h1 class="text-xl lg:text-3xl font-bold">01. Diagnosis Babyblues</h1>
                        <p class="text-gray-600">Diagnosis baby blues melibatkan evaluasi gejala seperti kecemasan, mudah tersinggung, atau kelelahan setelah melahirkan. Biasanya berlangsung beberapa hari hingga dua minggu dan dianggap normal, namun tetap memerlukan perhatian medis.</p>
                    </div>
                    <div class="flex items-center justify-center lg:justify-end h-[250px]">
                        <img src="{{ asset('1.svg') }}" alt="" class="h-full w-auto object-contain">
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="w-full grid lg:grid-cols-2 bg-white p-6 lg:p-10 rounded-lg shadow-lg min-h-[300px]">
                    <div class="flex items-center justify-center lg:justify-start order-2 lg:order-1 h-[250px]">
                        <img src="{{ asset('3.svg') }}" alt="" class="h-full w-auto object-contain">
                    </div>
                    <div class="space-y-4 flex flex-col justify-center order-1 lg:order-2">
                        <h1 class="text-xl lg:text-3xl font-bold">02. Konsultasi Babyblues</h1>
                        <p class="text-gray-600">Konsultasi baby blues melibatkan diskusi dengan profesional kesehatan seperti psikolog. Penting untuk menerima dukungan emosional, menilai kondisi ibu, dan menentukan apakah perawatan lebih lanjut diperlukan.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="w-full grid lg:grid-cols-2 bg-white p-6 lg:p-10 rounded-lg shadow-lg min-h-[300px]">
                    <div class="space-y-4 flex flex-col justify-center">
                        <h1 class="text-xl lg:text-3xl font-bold whitespace-nowrap">03. Rekomendasi Penanganan</h1>
                        <p class="text-gray-600">Mengelola baby blues antara lain dengan istirahat yang cukup, mendapat dukungan sosial dari keluarga, dan melakukan aktivitas relaksasi. Jika gejalanya menetap atau memburuk, terapi atau pengobatan dari profesional mungkin diperlukan untuk mencegah kondisi yang lebih serius seperti depresi pascapersalinan.</p>
                    </div>
                    <div class="flex items-center justify-center lg:justify-end h-[250px]">
                        <img src="{{ asset('2.svg') }}" alt="" class="h-full w-auto object-contain">
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="w-full bg-white py-20" id="how-it-works">
            <div class="w-full max-w-5xl mx-auto flex flex-col items-center px-4">
                <h1 class="text-center text-3xl lg:text-4xl font-bold mb-20">Bagaimana Cara Kerjanya?</h1>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-0 items-center">
                    <div class="flex justify-center">
                        <img src="{{ asset('Tablet login-amico.svg') }}" alt="" class="w-[200px] lg:w-[20rem]">
                    </div>
                    <div class="hidden lg:flex items-center justify-center">
                        <h1 class="text-6xl lg:text-8xl font-[800] text-yellow-500">01.</h1>
                    </div>
                    <div class="text-center lg:text-left">
                        <h1 class="text-2xl lg:text-3xl font-extrabold mb-4">Login</h1>
                        <p class="text-base lg:text-lg">Masuk ke akun Anda menggunakan email dan kata sandi Anda.</p>
                    </div>
                </div>
                <div class="hidden lg:flex items-center justify-center flex-col gap-9 mb-10">
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-0 items-center">
                    {{-- Image Section - First on mobile, Last on desktop --}}
                    <div class="flex justify-center lg:order-3 order-1">
                        <img src="{{ asset('stress.svg') }}" alt="" class="w-[200px] lg:w-[20rem]">
                    </div>

                    {{-- Number Section - Second on both --}}
                    <div class="hidden lg:flex items-center justify-center order-2">
                        <h1 class="text-6xl lg:text-8xl font-[800] text-yellow-500">02.</h1>
                    </div>

                    {{-- Text Section - Last on mobile, First on desktop --}}
                    <div class="text-center lg:text-left lg:order-1 order-3">
                        <h1 class="text-2xl lg:text-3xl font-extrabold mb-4">Diagnosa</h1>
                        <p class="text-base lg:text-lg">Fitur Diagnosis membantu pengguna menilai kesejahteraan emosional mereka setelah melahirkan dengan mengajukan serangkaian pertanyaan. Pengguna merespons dengan YA, BISA JADI, atau TIDAK berdasarkan pengalaman mereka, dan sistem mengevaluasi potensi kehadiran dan tingkat keparahan baby blues.</p>
                    </div>
                </div>
                <div class="hidden lg:flex items-center justify-center flex-col gap-9 mb-10">
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-0 items-center">
                    <div class="flex justify-center">
                        <img src="{{ asset('doctor.svg') }}" alt="" class="w-[200px] lg:w-[20rem]">
                    </div>
                    <div class="hidden lg:flex items-center justify-center">
                        <h1 class="text-6xl lg:text-8xl font-[800] text-yellow-500">03.</h1>
                    </div>
                    <div class="text-center lg:text-left">
                        <h1 class="text-2xl lg:text-3xl font-extrabold mb-4">Analis Laporan</h1>
                        <p class="text-base lg:text-lg">Hasilnya kemudian diolah menggunakan metode Kepastian Faktor (CF) pada fitur Analisis Laporan. Metode ini mengkategorikan kondisi pengguna ke dalam empat tingkatan: Tidak Berisiko, Risiko Rendah, Risiko Sedang, dan Risiko Berat. Jika analisis menunjukkan Risiko Parah, orang yang dapat dihubungi akan disediakan, memandu pengguna ke psikolog untuk konsultasi dan dukungan lebih lanjut.</p>
                    </div>
                </div>
                <!-- Similar responsive adjustments for other steps -->
            </div>
        </section>

        <!-- News Section -->
        <section class="w-full py-20 mb-10 px-4" id="berita">
            <div class="w-full max-w-6xl mx-auto">
                <h1 class="mb-20 text-3xl lg:text-4xl font-bold text-center">Berita Terkini</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-10">
                    @foreach ($news as $article)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col">
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                            @else
                                <img src="/images/no-image.jpg" alt="No Image" class="w-full h-48 object-cover">
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
