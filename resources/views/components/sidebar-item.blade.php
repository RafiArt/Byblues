{{-- sidebar-item.blade.php --}}
@props(['href', 'name'])
<li>
    <a href="{{ $href }}" {{ $attributes->except('href') }} class="hover:cursor-pointer">
        @php
            $isActive = false;
            $currentRoute = request()->route()->getName();
            $currentPath = request()->path();

            // Handle dashboard special case
            if ($name === 'Dashboard') {
                $isActive = $currentRoute === 'dashboard' || $currentPath === 'dashboard';
            } else {
                $isActive = $currentRoute === trim($href, '/') || $currentPath === trim($href, '/');
            }
        @endphp

        <div class="{{ $isActive ? 'text-blue-500 bg-blue-100' : 'hover:bg-gray-200' }} flex items-center gap-2 p-1 px-4 rounded-lg font-semibold transition">
            <div class="w-6 overflow-hidden flex items-center justify-center">
                {{ $slot }}
            </div>
            <p class="{{ $isActive ? 'text-blue-500 font-extrabold' : '' }} sidebar-title transition-all">
                {{ $name }}
            </p>
        </div>
    </a>
</li>
