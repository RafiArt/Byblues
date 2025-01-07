<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />
    <div class="bg-gray-100 p-4 lg:p-0 w-full h-screen flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg flex overflow-hidden w-full lg:w-[80rem] lg:h-[40rem]">
            <div class="flex-1 hidden lg:flex rounded-lg items-center justify-center bg-blue-700 m-4 relative"
                style="flex: 3; background-image: url('{{ asset('a.webp') }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                <!-- Transparent overlay with 70% transparency -->
                <div class="absolute inset-0 bg-white bg-opacity-70"></div>
                <!-- Logo SIER and text centered on top of the background -->
                <div class="relative z-20 flex flex-col items-center">
                    <img src="{{ asset('logosier.png') }}" alt="Logo SIER" class="w-24 h-36">
                    <!-- Text below the logo, above the overlay -->
                    <span class="mt-4 text-black font-bold text-2xl" style="font-family: 'Source Sans 3', sans-serif;">PT
                        Surabaya Industrial Estate Rungkut</span>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center p-6 md:p-10" style="flex: 2;">
                <div class="w-full">
                    <div class="flex items-center mb-3">
                        <h2 class="text-2xl font-semibold">Login SSO<span class="wave"></span></h2>
                    </div>
                    <p class="text-gray-500 mb-4">Please select your division.</p>
                    <form method="POST" action="{{ route('sso.divisiName') }}">
                        @csrf

                        <label for="division" class="block text-gray-700 font-medium mb-3">{{ __('Pilih Disivi:') }}</label>
                        <select name="division" class="w-full p-2 px-3 border-2 border-gray-300 rounded-lg mt-1 outline-none focus:ring-0 focus:border-blue-500" id="division" required>
                            <option value="" class="text-gray-700" disabled selected>Pilih Divisi</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name_divisions }}</option>
                            @endforeach
                        </select>

                        <div class="mt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white p-2 rounded-lg text-center hover:bg-blue-700">
                                {{ __('Submit') }}
                            </button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
