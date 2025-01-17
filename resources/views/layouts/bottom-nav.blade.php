<nav class="lg:hidden block fixed bottom-0 left-0 right-0 px-4 z-50 bg-white border-t border-gray-200">
    <div class="flex items-center justify-between">
        <x-bottom-nav-link href="/" icon="fa-gauge">Dashboard</x-bottom-nav-link>
        @if (Auth::user()->hasRole('user'))
            {{-- <x-bottom-nav-link href="/analytics" icon="fa-chart-simple">Analytics</x-bottom-nav-link> --}}
            <x-bottom-nav-link href="/diagnosa" icon="fa-hand-holding-medical ">Diagnosis</x-bottom-nav-link>
            <x-bottom-nav-link href="/profile" icon="fa-user ">Profile</x-bottom-nav-link>
            {{-- <x-bottom-nav-link href="/qrcodes" icon="fa-qrcode">QRCodes</x-bottom-nav-link> --}}
        @else
            {{-- <x-bottom-nav-link href="/analytics_admin" icon="fa-chart-simple">Analytics</x-bottom-nav-link> --}}
            <x-bottom-nav-link href="/diagnosa_admin" icon="fa-hand-holding-medical">Diagnosis</x-bottom-nav-link>
            <x-bottom-nav-link href="/gejala" icon="fa-laptop-medical">Gejala</x-bottom-nav-link>
            <x-bottom-nav-link href="/user_management" icon="fa-user">User</x-bottom-nav-link>
        @endif
    </div>
</nav>
