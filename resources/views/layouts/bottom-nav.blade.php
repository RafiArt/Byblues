<nav class="lg:hidden block fixed bottom-0 left-0 right-0 px-4 z-50 bg-white border-t border-gray-200">
    <div class="flex items-center justify-between">
        <x-bottom-nav-link href="/" icon="fa-gauge">Dashboard</x-bottom-nav-link>
        @if (Auth::user()->hasRole('user'))
            <x-bottom-nav-link href="/analytics" icon="fa-chart-simple">Analytics</x-bottom-nav-link>
            <x-bottom-nav-link href="/links" icon="fa-stethoscope">Links</x-bottom-nav-link>
            <x-bottom-nav-link href="/qrcodes" icon="fa-qrcode">QRCodes</x-bottom-nav-link>
        @else
            <x-bottom-nav-link href="/analytics_admin" icon="fa-chart-simple">Analytics</x-bottom-nav-link>
            <x-bottom-nav-link href="/links_admin" icon="fa-stethoscope">Links</x-bottom-nav-link>
            <x-bottom-nav-link href="/qrcodes_admin" icon="fa-qrcode">QRCodes</x-bottom-nav-link>
            <x-bottom-nav-link href="/user_management" icon="fa-user">User</x-bottom-nav-link>
        @endif
    </div>
</nav>
