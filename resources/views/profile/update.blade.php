<x-dashboard-layout title="Profile">
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Sidebar Content (Left) -->
        <x-side-layout />

        <!-- Profile Form (Right) -->
        <div class="flex-1">
            <div class="bg-white p-6 rounded shadow">
                <h1 class="text-2xl font-semibold mb-4">Update Profile</h1>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            class="mt-1 p-2 border border-blue-500 rounded w-full">
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="mt-1 p-2 border border-blue-500 rounded w-full">
                    </div>

                    <!-- Password Verification Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Verify Password</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 p-2 border border-blue-500 rounded w-full" required>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
