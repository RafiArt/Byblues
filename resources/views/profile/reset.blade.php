<x-dashboard-layout title="Profile">
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Sidebar Content (Left) -->
        <x-side-layout />

        <!-- Profile Form (Right) -->
        <div class="flex-1">
            <div class="bg-white p-6 rounded shadow">
                <h1 class="text-2xl font-semibold mb-4">Reset Password</h1>
                <form action="{{ route('profile.reset') }}" method="POST">
                    @csrf

                    <!-- Current Password Field -->
                    <div class="mb-4 relative">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current
                            Password</label>
                        <div class="mt-1 relative">
                            <input type="password" name="current_password" id="current_password"
                                class="mt-1 p-2 border border-blue-500 rounded w-full" required>
                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer"
                                onclick="togglePasswordVisibility('current_password', this)">
                                <i class="fas fa-eye" id="current_password_icon"></i>
                            </span>
                        </div>
                        @error('current_password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New Password Field -->
                    <div class="mb-4 relative">
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <div class="mt-1 relative">
                            <input type="password" name="password" id="password"
                                class="p-2 border border-blue-500 rounded w-full" required>
                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer"
                                onclick="togglePasswordVisibility('password', this)">
                                <i class="fas fa-eye" id="password_icon"></i>
                            </span>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Confirm Password Field -->
                    <div class="mb-4 relative">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                            Password</label>
                        <div class="mt-1 relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="mt-1 p-2 border border-blue-500 rounded w-full" required>
                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer"
                                onclick="togglePasswordVisibility('password_confirmation', this)">
                                <i class="fas fa-eye" id="password_confirmation_icon"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Reset Password
                        </button>
                    </div>
                </form>

                <script>
                    function togglePasswordVisibility(inputId, iconElement) {
                        const inputField = document.getElementById(inputId);
                        const icon = iconElement.querySelector('i');

                        // Toggle the type attribute
                        if (inputField.type === 'password') {
                            inputField.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            inputField.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                </script>


            </div>
        </div>
    </div>
</x-dashboard-layout>
