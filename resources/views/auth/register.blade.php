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
                        <div class="bg-blue-500 w-8 h-8 rounded-full flex items-center justify-center">
                            <i class="fas fa-stethoscope text-white"></i>
                        </div>
                        <h2 class="text-2xl font-semibold ml-2">Welcome to {{ ENV('APP_NAME') }} <span class="wave"></span></h2>
                    </div>
                    <p class="text-gray-500 mb-3">Please register to your account</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-1.5">
                            <label for="name" class="block text-gray-700">{{ __('Name') }}</label>
                            <input id="name"
                                class="w-full p-2 border border-blue-400 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-blue-500 @enderror"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-blue-500 text-sm" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-1.5">
                            <label for="email" class="block text-gray-700">{{ __('Email') }}</label>
                            <input id="email"
                                class="w-full p-2 border border-blue-400 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-blue-500 @enderror"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-blue-500 text-sm" />
                        </div>

                        <!-- Peran -->
                        <div class="mb-1.5">
                            <label for="peran" class="block text-gray-700">{{ __('Peran') }}</label>
                            <select id="peran"
                                    name="peran"
                                    class="w-full p-2 border border-blue-400 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('peran') border-blue-500 @enderror"
                                    required>
                                <option value="Ibu" {{ old('peran') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="Suami" {{ old('peran') == 'Suami' ? 'selected' : '' }}>Suami</option>
                                <option value="Orang Tua" {{ old('peran') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                            </select>
                            <x-input-error :messages="$errors->get('peran')" class="mt-2 text-blue-500 text-sm" />
                        </div>


                        <!-- Password -->
                        <div class="mb-1.5 relative">
                            <label for="password" class="block text-gray-700">{{ __('Password') }}</label>
                            <input id="password"
                                class="w-full p-2 border border-blue-400 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-blue-500 @enderror"
                                type="password"
                                placeholder="••••••••"
                                name="password"
                                required
                                autocomplete="new-password" />
                            <a class="absolute right-2 top-12 transform -translate-y-1/2 text-gray-500" href="javascript:void(0);" onclick="togglePassword('password', 'eye-icon')">
                                <i id="eye-icon" class="fas fa-eye-slash"></i>
                            </a>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-blue-500 text-sm" />
                        </div>


                        <!-- Confirm Password -->
                        <div class="mb-1.5 relative">
                            <label for="password_confirmation" class="block text-gray-700">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation"
                                class="w-full p-2 border border-blue-400 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password_confirmation') border-blue-500 @enderror"
                                type="password"
                                placeholder="••••••••"
                                name="password_confirmation"
                                required
                                autocomplete="new-password" />
                            <a class="absolute right-2 top-12 transform -translate-y-1/2 text-gray-500" href="javascript:void(0);" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')">
                                <i id="eye-icon-confirm" class="fas fa-eye-slash"></i>
                            </a>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-blue-500 text-sm" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="w-full p-2 border border-blue-400 rounded text-center bg-blue-500 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-gray-500">If you already have an account? <a class="text-blue-500" href="/login"> Already registered</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
