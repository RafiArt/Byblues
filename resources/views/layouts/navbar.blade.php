{{-- resources/views/layouts/navbar.blade.php --}}
@php
    $activePage = request()->path(); // Mendapatkan path URL saat ini
@endphp

<nav class="relative w-full h-[80px] flex items-center justify-center bg-[#1e40af] px-4 z-50">
    {{-- Desktop Navigation --}}
    <div class="w-full h-full max-w-7xl hidden md:flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-stethoscope text-3xl text-white"></i>
            <h1 class="text-2xl font-bold text-white">Byblues</h1>
        </div>
        <ul class="flex items-center gap-3 h-full text-white">
            <li>
                <a href="/" class="block py-2 px-4 font-semibold rounded hover:bg-blue-950 hover:text-white transition {{ $activePage === '/' ? 'bg-white text-[#1e40af]' : '' }}">Home</a>
            </li>
            <li>
                <a href="/about" class="block py-2 px-4 font-semibold rounded hover:bg-blue-950 hover:text-white transition {{ $activePage === 'about' ? 'bg-white text-[#1e40af]' : '' }}">About</a>
            </li>
        </ul>
        <div class="flex items-center justify-center gap-3">
            <a href="/login" class="py-2 px-4 font-semibold rounded bg-white text-[#1e40af] hover:bg-gray-200 hover:text-[#1e40af] transition border-2 border-white">Login</a>
            <a href="/register" class="py-2 px-4 font-semibold rounded hover:bg-gray-200 hover:text-[#1e40af] transition border-2 border-white text-white">Register</a>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div class="md:hidden w-full bg-[#1e40af]">
        <div class="px-4 py-3 flex justify-between items-center h-[80px]">
            <a href="/" class="text-2xl font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-stethoscope text-3xl text-white"></i>
                BYBLUES
            </a>
            <button id="mobile-menu-button" class="text-white hover:text-gray-200">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>
        <div id="mobile-menu" class="hidden fixed top-[80px] left-0 right-0 bg-[#1e40af] w-full z-50 overflow-visible">
            <div class="px-4 py-3 space-y-4">
                <a href="/" class="block hover:bg-blue-950 py-2 px-4 rounded {{ $activePage === '/' ? 'bg-blue-950 text-white' : 'text-black' }}">Home</a>
                <a href="/about" class="block hover:bg-blue-950 py-2 px-4 rounded {{ $activePage === 'about' ? 'bg-blue-950 text-black' : 'text-white' }}">About</a>
                <div class="pt-4 border-t border-gray-200">
                    <a href="/login" class="block w-full text-center bg-white text-[#1e40af] hover:bg-gray-200 hover:text-[#1e40af] py-2 rounded-lg mb-2">Login</a>
                    <a href="/register" class="block w-full text-center border-2 border-white hover:bg-gray-200 hover:text-[#1e40af] text-white py-2 rounded-lg">Register</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    // Toggle menu when button is clicked
    mobileMenuButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent click from bubbling to document
        mobileMenu.classList.toggle('hidden');
    });

    // Close menu when clicking anywhere else on the document
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = mobileMenu.contains(event.target);
        const isClickOnButton = mobileMenuButton.contains(event.target);

        if (!isClickInsideMenu && !isClickOnButton && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Prevent menu from closing when clicking inside it
    mobileMenu.addEventListener('click', function(event) {
        event.stopPropagation();
    });
</script>
