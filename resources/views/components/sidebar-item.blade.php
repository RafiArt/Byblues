<li>
    <a {{ $attributes }} class="hover:cursor-pointer">
        <div
            class="{{ ($href === '/' ? request()->path() === '/' : str_starts_with(request()->url(), url($href))) ? 'text-blue-500 bg-blue-100' : 'hover:bg-gray-200' }} flex items-center gap-2 p-1 px-4 rounded-lg font-semibold transition">
            <div class="w-6 overflow-hidden flex items-center justify-center">
                {{ $slot }}
            </div>
            <p
                class="{{ ($href === '/' ? request()->path() === '/' : str_starts_with(request()->url(), url($href))) ? 'text-blue-500 font-extrabold' : '' }} sidebar-title transition-all">
                {{ $name }}
            </p>
        </div>
    </a>
</li>
