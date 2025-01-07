<aside class="w-full lg:w-1/4">
    <div class="bg-white shadow">
        <div class="space-y-0 flex flex-col">
            <!-- All Sections in One -->
            <div>
                <a href="{{ route('profile.show') }}"
                    class="flex items-center w-full px-4 py-3 text-left
                        {{ request()->routeIs('profile.show')
                            ? 'text-blue-500 bg-blue-500 bg-opacity-20'
                            : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-300 transition' }}">
                    <i class="fas fa-info-circle mr-2 text-lg ml-1"></i>
                    Informasi Profile
                </a>
            </div>
            <div>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center w-full px-4 py-3 text-left
                    {{ request()->is('profile/edit')
                        ? 'text-blue-500 bg-blue-500 bg-opacity-20'
                        : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-300 transition' }}">
                    <i class="fas fa-user-edit mr-2 text-lg ml-1"></i>
                    Update Profile
                </a>
            </div>

            {{-- <div>
                <a href="{{ route('profile.reset') }}"
                    class="flex items-center w-full px-4 py-3 text-left
                    {{ request()->is('profile/reset')
                        ? 'text-red-500 bg-red-500 bg-opacity-20'
                        : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-300 transition' }}">
                    <i class="fas fa-lock mr-2 text-lg ml-1"></i>
                    Reset Password
                </a>
            </div> --}}
        </div>
    </div>
</aside>
