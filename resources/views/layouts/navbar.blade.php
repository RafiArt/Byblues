{{-- resources/views/layouts/navbar.blade.php --}}
<nav class="relative w-full h-[80px] hidden md:flex items-center justify-center bg-[#1e40af] px-4 z-50">
    <div class="w-full h-full max-w-7xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-stethoscope text-3xl text-white"></i>
            <h1 class="text-2xl font-bold text-white">Byblues</h1>
        </div>
        <ul class="flex items-center gap-3 h-full text-white">
            <li><a href="/" class="block py-2 px-4 font-semibold rounded hover:bg-blue-950 transition">Home</a></li>
            <li><a href="/" class="block py-2 px-4 font-semibold rounded hover:bg-blue-950 transition">About</a></li>
        </ul>
        <div class="flex items-center justify-center gap-3">
            <a href="/login" class="py-2 px-4 font-semibold rounded bg-white text-blue-950 hover:bg-gray-200 hover:border-gray-200 border-2 border-white transition">Login</a>
            <a href="/register" class="py-2 px-4 font-semibold rounded hover:bg-white hover:text-blue-950 transition border-2 border-white text-white">Register</a>
        </div>
    </div>
</nav>

{{-- Mobile Navigation --}}
<div class="lg:hidden">
    <nav class="fixed top-0 w-full bg-white shadow-lg z-50">
        <div class="px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-800 flex items-center gap-2">
                <i class="fa-solid fa-stethoscope text-3xl text-blue-800"></i>
                BYBLUES
            </a>
            <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>
        <div id="mobile-menu" class="hidden bg-white w-full">
            <div class="px-4 py-3 space-y-4">
                <a href="/" class="block text-gray-700 hover:text-blue-800">Home</a>
                <a href="#berita" class="block text-gray-700 hover:text-blue-800">About</a>
                <div class="pt-4 border-t border-gray-200">
                    <a href="/login" class="block w-full text-center bg-blue-800 text-white py-2 rounded-lg mb-2">Login</a>
                    <a href="/register" class="block w-full text-center bg-orange-500 text-white py-2 rounded-lg">Register</a>
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>

