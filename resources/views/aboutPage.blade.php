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

    <!-- About Section -->
    <section class="bg-white py-20">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">Tentang <span class="text-blue-600">Kami</span></h2>
                <div class="w-24 h-1 bg-blue-500 mx-auto mb-8"></div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Byblues - Aplikasi Pendeteksi dan Konsultasi BabyBlues</p>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Visi Card -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md transform transition duration-500 hover:shadow-lg">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Visi Kami</h3>
                    <p class="text-gray-600">Menjadi platform terdepan dalam pendeteksian dini baby blues dan memberikan dukungan komprehensif bagi ibu pasca melahirkan di Indonesia.</p>
                </div>

                <!-- Misi Card -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md transform transition duration-500 hover:shadow-lg">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-rocket text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Misi Kami</h3>
                    <p class="text-gray-600">Menyediakan akses mudah untuk deteksi dini, konsultasi profesional, dan rekomendasi penanganan baby blues bagi seluruh ibu di Indonesia.</p>
                </div>

                <!-- Nilai Card -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md transform transition duration-500 hover:shadow-lg">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Nilai Kami</h3>
                    <p class="text-gray-600">Kepedulian, profesionalisme, empati, dan komitmen untuk mendukung kesehatan mental ibu pasca melahirkan menjadi dasar dari setiap layanan kami.</p>
                </div>
            </div>

            <!-- About Content -->
            <div class="mt-16 bg-gray-50 p-8 rounded-xl shadow-md">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Tentang Kami</h3>
                <p class="text-gray-600 mb-6">
                    Byblues adalah platform pendeteksi baby blues yang dirancang untuk membantu ibu-ibu pasca melahirkan dalam mengenali gejala baby blues sejak dini. Kami memahami bahwa periode pasca melahirkan adalah masa yang penuh tantangan, dan kesehatan mental ibu sering kali tidak mendapatkan perhatian yang cukup.
                </p>
                <p class="text-gray-600 mb-6">
                    Aplikasi kami menyediakan alat deteksi diri yang mudah digunakan, berbasis penelitian ilmiah terkini. Selain itu, kami juga menghubungkan ibu-ibu dengan konselor atau psikolog profesional yang berpengalaman dalam menangani baby blues dan depresi pasca melahirkan.
                </p>
                <p class="text-gray-600">
                    Tim kami terdiri dari psikolog, konselor, dan tim IT yang berdedikasi untuk memberikan dukungan dan bimbingan bagi ibu-ibu dalam menghadapi tantangan emosional pasca melahirkan. Kami percaya bahwa dengan deteksi dini dan dukungan yang tepat, baby blues dapat ditangani dengan baik dan tidak berkembang menjadi masalah kesehatan mental yang lebih serius.
                </p>
            </div>

            <!-- Contact Info -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-8 rounded-xl shadow-md">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="mr-4 mt-1">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Nama Perusahaan:</p>
                                <p class="text-gray-600">Raftech.dev</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="mr-4 mt-1">
                                <i class="fas fa-globe text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Nama Website:</p>
                                <p class="text-gray-600">Byblues</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="mr-4 mt-1">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Email:</p>
                                <a href="mailto:rafiart441@gmail.com" class="text-blue-600 hover:underline">rafiart441@gmail.com</a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="mr-4 mt-1">
                                <i class="fab fa-whatsapp text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">WhatsApp:</p>
                                <a href="https://wa.me/6285706919197" class="text-blue-600 hover:underline">+6285706919197</a>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow-md flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Konsultasi Mudah dan Cepat</h3>
                    <p class="text-gray-600 mb-8">Dapatkan bantuan profesional untuk mengatasi baby blues dengan konsultasi online yang nyaman dan terpercaya. Kami siap mendampingi Anda!</p>
                    <a href="/login" class="self-start bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 flex items-center">
                        Mulai Konsultasi <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>


    @include('layouts.footer')

</body>
</html>
