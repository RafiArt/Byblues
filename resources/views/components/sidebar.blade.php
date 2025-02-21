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
            <x-sidebar-item href="{{ route('dashboard') }}" name="Dashboard">
                <i class="fa-solid fa-gauge text-lg"></i>
            </x-sidebar-item>
            @if (Auth::user()->hasRole('administrator'))
                {{-- <x-sidebar-item href="/analytics_admin" name="Analytics"><i
                        class="fa-solid fa-chart-simple text-lg"></i></x-sidebar-item> --}}
                <x-sidebar-item href="diagnosa_admin" name="Diagnosis"><i
                        class="fa-solid fa-hand-holding-medical text-lg"></i></x-sidebar-item>
                <x-sidebar-item href="/gejala" name="Gejala"><i class="fa-solid fa-laptop-medical text-lg"></i></x-sidebar-item>
                <x-sidebar-item href="/news" name="News"><i class="fa-solid  fa-newspaper text-lg"></i></x-sidebar-item>
                {{-- <x-sidebar-item href="#" name="History"><i
                        class="fa-solid fa-receipt text-lg"></i></x-sidebar-item> --}}
                <x-sidebar-item href="/user_management" name="User Management"><i
                        class="fa-solid fa-user text-lg"></i></x-sidebar-item>
            @else
                {{-- <x-sidebar-item href="/analytics" name="Analytics">
                    <i class="fa-solid fa-chart-simple text-lg"></i>
                </x-sidebar-item> --}}
                <x-sidebar-item href="/diagnosa" name="Diagnosis">
                    <i class="fa-solid fa-hand-holding-medical  text-lg"></i>
                </x-sidebar-item>
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
