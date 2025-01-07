<nav class="w-full h-[70px] border-b bg-white sticky top-0 p-2 px-4 flex items-center justify-between z-[999]">
    <div class="flex items-center gap-6">
        <button id="toggleSidebar" title="Toggle Sidebar"
            class="hidden lg:flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-200 transition">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        <p class="text-xl font-semibold">{{ $title }}</p>
    </div>
    <div class="flex items-center gap-5 text-xl">
        <button id="toggleDropdown" title="Menu Dropdown"
            class="flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-200 transition">
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button>
    </div>
    <div id="nav-dropdown"
        class="w-[12rem] hidden p-2 absolute top-[4rem] right-2 rounded-lg shadow-lg bg-white z-[90] border">
        <ul class="flex flex-col gap-1">
            <li>
                <a href="{{ route('profile.show') }}" class="p-2 py-1 block hover:bg-gray-200 rounded transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 overflow-hidden flex items-center justify-center">
                            <i class="fa-solid fa-address-card text-lg text-blue-500"></i>
                        </div>
                        <p class="font-semibold text-sm text-blue-500">Profile</p>
                    </div>
                </a>
            </li>
            @unless(Auth::user()->roles[0]->name == 'administrator')
                <li class="block lg:hidden">
                    <a href="/division_links">
                        <button type="submit" class="w-full p-2 py-1 block hover:bg-gray-200 rounded transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 overflow-hidden flex items-center justify-center">
                                    <i class="fa-solid fa-building-user text-lg text-blue-500"></i>
                                </div>
                                <p class="font-semibold text-sm text-blue-500">Links Division</p>
                            </div>
                        </button>
                    </a>
                </li>
                <li class="block lg:hidden">
                    <a href="/division_qrcodes">
                        <button type="submit" class="w-full p-2 py-1 block hover:bg-gray-200 rounded transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 overflow-hidden flex items-center justify-center">
                                    <i class="fa-solid fa-qrcode text-lg text-blue-500"></i>
                                </div>
                                <p class="font-semibold text-sm text-blue-500">QR Division</p>
                            </div>
                        </button>
                    </a>
                </li>
            @endunless
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full p-2 py-1 block hover:bg-gray-200 rounded transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 overflow-hidden flex items-center justify-center">
                                <i class="fa-solid fa-door-open text-lg text-blue-500"></i>
                            </div>
                            <p class="font-semibold text-sm text-blue-500">Logout</p>
                        </div>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>

<script>
    document.getElementById('toggleDropdown').addEventListener('click', function() {
        document.getElementById('nav-dropdown').classList.toggle('hidden');
    });

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('#toggleDropdown') && !event.target.closest('#nav-dropdown')) {
            var dropdown = document.getElementById('nav-dropdown');
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        }
    };
</script>
