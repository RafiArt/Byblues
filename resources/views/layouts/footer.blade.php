<footer class="w-full py-10 bg-gray-100 px-4">
    <div class="w-full max-w-7xl mx-auto flex flex-col justify-center items-center">
        {{-- Logo, Judul, dan Deskripsi (Rata Kiri di Mobile) --}}
        <div class="w-full flex flex-col md:hidden mb-8 text-left">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa-solid fa-stethoscope text-4xl text-blue-600"></i>
                <h1 class="text-4xl font-bold text-blue-600">Byblues</h1>
            </div>
            <p class="text-left">Smart Solution for Quickly and Effectively Detecting Baby Blues!</p>
        </div>

        {{-- Grid Container untuk Menus, Services, dan Help --}}
        <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-20">
            {{-- Logo dan Deskripsi (Muncul di Layar Besar) --}}
            <div class="w-full hidden md:flex flex-col">
                <div class="flex items-center gap-3 mb-4">
                    <i class="fa-solid fa-stethoscope text-4xl text-blue-600"></i>
                    <h1 class="text-4xl font-bold text-blue-600">Byblues</h1>
                </div>
                <p>Smart Solution for Quickly and Effectively Detecting Baby Blues!</p>
            </div>

            {{-- Menus, Services, dan Help --}}
            <div class="w-full text-gray-800 grid grid-cols-3 gap-4 md:flex md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold mb-5">Menus</h2>
                    <div class="w-full flex flex-col gap-4">
                        <a href="#" class="hover:underline w-fit text-sm">Home</a>
                        <a href="/abot" class="hover:underline w-fit text-sm">About</a>
                        <a href="/login" class="hover:underline w-fit text-sm">Login</a>
                        <a href="/register" class="hover:underline w-fit text-sm">Register</a>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-5">Services</h2>
                    <div class="w-full flex flex-col gap-4">
                        <a href="#" class="hover:underline w-fit text-sm">Diagnosis Babyblues</a>
                        <a href="#" class="hover:underline w-fit text-sm">Konsultasi Babyblues</a>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-5">Help</h2>
                    <div class="w-full flex flex-col gap-4">
                        <a href="#" class="hover:underline w-fit text-sm">Contact Us</a>
                    </div>
                </div>
            </div>

            {{-- Gambar (Sembunyikan di Mobile) --}}
            <div class="w-full hidden md:block mt-8">
                <img src="{{ asset('hospital2.png') }}" alt="" class="my-[-80px] drop-shadow-xl h-80">
            </div>
        </div>

        {{-- Garis Pembatas --}}
        <div class="w-full border-b-2 my-10 md:my-20 mb-5"></div>

        {{-- Copyright --}}
        <div class="w-full">
            <p class="text-center text-gray-800 text-sm">Copyright © 2025 Byblues.</p>
        </div>
    </div>
</footer>
