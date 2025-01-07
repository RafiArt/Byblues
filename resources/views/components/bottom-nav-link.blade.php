<a {{ $attributes }}
    class="{{ request()->fullUrlIs(url($href)) ? 'text-blue-600' : 'text-gray-400' }} flex flex-col flex-1 gap-1 items-center justify-center p-3  font-semibold">
    <i class="fa-solid {{ $icon }} text-xl"></i>
    <p class="text-xs">{{ $slot }}</p>
</a>
