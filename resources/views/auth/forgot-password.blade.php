<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="bg-white shadow-lg rounded-lg flex overflow-hidden w-full h-screen">
        <div class="flex-1 flex rounded-lg items-center justify-center bg-blue-700 p-10 m-4 relative" style="flex: 3; background-image: url('{{ asset('a.webp') }}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
            <!-- Transparent overlay with 70% transparency -->
            <div class="absolute inset-0 bg-white bg-opacity-70"></div>
            <!-- Logo SIER and text centered on top of the background -->
            <div class="relative z-20 flex flex-col items-center">
                <img src="{{ asset('logosier.png') }}" alt="Logo SIER" class="w-24 h-36">
                <!-- Text below the logo, above the overlay -->
                <span class="mt-4 text-black font-bold text-2xl" style="font-family: 'Source Sans 3', sans-serif;">PT Surabaya Industrial Estate Rungkut</span>
            </div>
        </div>
        <div class="flex-1 flex items-center justify-center p-10" style="flex: 2;">
            <div class="w-full">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-500 w-8 h-8 rounded-full flex items-center justify-center">
                        <i class="fas fa-link text-white"></i>
                    </div>
                    <h2 class="text-2xl font-semibold ml-2">Welcome to {{ ENV('APP_NAME') }} <span class="wave"></span></h2>
                </div>
                <p class="text-gray-500 mb-6">Forgot password? Enter your email, and we'll send you a reset link.</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">{{ __('Email') }}</label>
                        <input id="email"
                            class="w-full p-2 border border-blue-400 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-blue-500 @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            type="email"
                            required
                            autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-blue-500 text-sm" />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4 mb-4">
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded text-center hover:bg-blue-700">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                    <div class="w-full border-t border-gray-300 my-2"></div>
                </form>
                <div class="mt-4 flex justify-between">
                    <a href="{{ route('login') }}" class="w-1/2 bg-blue-500 text-white p-2 rounded text-center hover:bg-blue-700 mr-2">
                        {{ __('Login') }}
                    </a>

                    <a href="{{ route('register') }}" class="w-1/2 text-blue-500 border border-blue-500 p-2 rounded text-center hover:bg-blue-700 hover:text-white">
                        {{ __('Register') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
