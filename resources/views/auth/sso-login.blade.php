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
                    <p class="text-gray-500 mb-6">Please log in using your SSO account</p>
                    <form method="POST" action="{{ route('sso.store') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="usercode" class="block text-gray-700 font-medium">{{ __('Usercode') }}</label>
                            <input id="usercode"
                                class="w-full p-2 px-3 border-2 border-gray-300 rounded-lg mt-1 outline-none focus:ring-0 focus:border-blue-500 @error('usercode') focus:border-red-500  @enderror"
                                name="usercode" value="{{ old('usercode') }}" placeholder="Enter your usercode"
                                type="usercode" required autofocus autocomplete="username" />
                            {{-- <x-input-error :messages="$errors->get('usercode')" class="mt-2 text-blue-500 text-sm" /> --}}
                            @if (session('error'))
                                <p class="text-red-500 text-sm mt-1 italic">*{{ session('error') }}</p>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="mb-4 relative">
                            <label for="password" class="block text-gray-700 font-medium">{{ __('Password') }}</label>
                            <input id="password"
                                class="w-full p-2 px-3 border-2 border-gray-300 rounded-lg mt-1 outline-none focus:ring-0 focus:border-blue-500 @error('password') focus:border-red-500  @enderror"
                                type="password" name="password" placeholder="••••••••" required
                                autocomplete="new-password" />
                            <a class="absolute right-4 top-1/2 transform  text-gray-400 hover:text-blue-600 transition hover:cursor-pointer"
                                href="javascript:void(0);" onclick="togglePassword('password', 'eye-icon')">
                                <i id="eye-icon" class="fas fa-eye-slash text-lg "></i>
                            </a>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-blue-500 text-sm" />
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4 flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="mr-2 rounded border-gray-300 text-blue-500 shadow-sm focus:ring-blue-500"
                                name="remember" {{ old('remember') ? 'checked' : '' }} />
                            <label class="text-gray-700" for="remember_me">{{ __('Remember Me') }}</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white p-2 rounded-lg text-center hover:bg-blue-700">
                                {{ __('Sign in') }}
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-gray-500">Login with credentials? <a class="text-blue-500 hover:underline"
                                href="/login">Login</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
