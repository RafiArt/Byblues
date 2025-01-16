<aside id="sidebar-wrapper"
    class="w-[18rem] h-screen bg-white border-r border-gray-200 shadow-lg px-4 lg:block sticky top-0 hidden">
    <div class="h-[70px] w-full flex items-center justify-center py-4">
        <a href="/" class="flex items-center gap-3">
            <i class="fa-solid fa-stethoscope  text-3xl text-blue-600"></i>
            <h1 id="logo-text" class="text-2xl font-bold text-blue-600">{{ ENV('APP_NAME') . env('APP_DOMAIN') }}</h1>
        </a>
    </div>
    <div class="mt-5 w-full flex flex-col text-sm">
        <ul id="sidebar-items" class="flex flex-col gap-2">
            <x-sidebar-item href="/" name="Dashboard">
                <i class="fa-solid fa-gauge text-lg"></i>
            </x-sidebar-item>
            @if (Auth::user()->hasRole('administrator'))
                <x-sidebar-item href="/analytics_admin" name="Analytics"><i
                        class="fa-solid fa-chart-simple text-lg"></i></x-sidebar-item>
                <x-sidebar-item href="diagnosa_admin" name="Babyblues"><i
                        class="fa-solid fa-hand-holding-medical text-lg"></i></x-sidebar-item>
                <x-sidebar-item href="/gejala" name="Gejala"><i class="fa-solid fa-laptop-medical"></i></x-sidebar-item>
                <x-sidebar-item href="#" name="History"><i
                        class="fa-solid fa-receipt text-lg"></i></x-sidebar-item>
                <x-sidebar-item href="/user_management" name="User Management"><i
                        class="fa-solid fa-user text-lg"></i></x-sidebar-item>
            @else
                <x-sidebar-item href="/analytics" name="Analytics">
                    <i class="fa-solid fa-chart-simple text-lg"></i>
                </x-sidebar-item>
                <x-sidebar-item href="/diagnosa" name="Diagnosis">
                    <i class="fa-solid fa-hand-holding-medical  text-lg"></i>
                </x-sidebar-item>
                <x-sidebar-item href="#" name="History Cek">
                    <i class="fa-solid fa-receipt text-lg"></i>
                </x-sidebar-item>

                {{-- <!-- Submenu for Links -->
                <li class="relative">
                    <div class="flex items-center justify-between p-1 px-4 rounded-lg hover:bg-gray-200 cursor-pointer"
                        onclick="toggleSubmenu('linksSubmenu', 'linksChevron')">
                        <span class="flex items-center text-gray-800 gap-2 font-semibold">
                            <div class="w-6 overflow-hidden flex items-center justify-center">
                                <i class="fa-solid fa-link text-lg"></i>
                            </div>
                            <span class="sidebar-title">Links</span>
                        </span>
                        <i id="linksChevron" class="fa-solid fa-chevron-down text-gray-800 text-sm sidebar-title"></i>
                    </div>
                    <ul id="linksSubmenu" class="ml-4 flex flex-col hidden gap-2 my-2 text-sm">
                        <li>
                            <a href="/links" class="hover:cursor-pointer">
                                <div
                                    class="{{ str_starts_with(request()->url(), url('/links')) ? 'text-blue-500 bg-blue-100' : 'hover:bg-gray-200' }} flex items-center gap-2 p-2 px-4 rounded-lg font-semibold transition">
                                    <p
                                        class="{{ str_starts_with(request()->url(), url('/links')) ? 'text-blue-500 font-extrabold' : '' }} sidebar-title transition-all">
                                        My Links
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/division_links" class="hover:cursor-pointer">
                                <div
                                    class="{{ str_starts_with(request()->url(), url('/division_links')) ? 'text-blue-500 bg-blue-100' : 'hover:bg-gray-200' }} flex items-center gap-2 p-2 px-4 rounded-lg font-semibold transition">
                                    <p
                                        class="{{ str_starts_with(request()->url(), url('/division_links')) ? 'text-blue-500 font-extrabold' : '' }} sidebar-title transition-all">
                                        Division Links
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Submenu for QR Codes -->
                <li class="relative">
                    <div class="flex items-center justify-between p-1 px-4 rounded-lg hover:bg-gray-200 cursor-pointer"
                        onclick="toggleSubmenu('qrSubmenu', 'qrChevron')">
                        <span class="flex items-center text-gray-800 gap-2 font-semibold">
                            <div class="w-6 overflow-hidden flex items-center justify-center">
                                <i id="qrIcon" class="fa-solid fa-qrcode text-lg"></i>
                            </div>
                            <span class="sidebar-title">QR Codes</span>
                        </span>
                        <i id="qrChevron" class="fa-solid fa-chevron-down text-gray-800 text-sm sidebar-title"></i>
                    </div>
                    <ul id="qrSubmenu" class="ml-4 flex flex-col hidden gap-2 my-2">
                        <li>
                            <a href="/qrcodes" class="hover:cursor-pointer">
                                <div
                                    class="{{ request()->fullUrlIs(url('/qrcodes')) ? 'text-blue-500 bg-blue-100' : 'hover:bg-gray-200' }} flex items-center gap-2 p-2 px-4 rounded-lg font-semibold transition">
                                    <p
                                        class="{{ request()->fullUrlIs(url('/qrcodes')) ? 'text-blue-500 font-extrabold' : '' }} sidebar-title transition-all">
                                        My QR Codes</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/division_qrcodes" class="hover:cursor-pointer">
                                <div
                                    class="{{ request()->fullUrlIs(url('/division_qrcodes')) ? 'text-blue-500 bg-blue-100' : 'hover:bg-gray-200' }} flex items-center gap-2 p-2 px-4 rounded-lg font-semibold transition">
                                    <p
                                        class="{{ request()->fullUrlIs(url('/division_qrcodes')) ? 'text-blue-500 font-extrabold' : '' }} sidebar-title transition-all">
                                        Division QR Codes</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            @endif
        </ul>
    </div>
</aside>

<script>
    function toggleSubmenu(submenuId, chevronId) {
        const submenu = document.getElementById(submenuId);
        const chevron = document.getElementById(chevronId);

        // Toggle visibility of the submenu
        submenu.classList.toggle('hidden');

        // Toggle the chevron icon direction
        chevron.classList.toggle('fa-chevron-up');
        chevron.classList.toggle('fa-chevron-down');
    }
</script>
