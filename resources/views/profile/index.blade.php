<x-dashboard-layout title="Profile">
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Sidebar Content (Left) -->
        <x-side-layout />

        <!-- Profile Form (Right) -->
        <div class="flex-1 ">
            <div class="bg-white p-6 rounded shadow">
                <h1 class="text-2xl font-semibold mb-4">Informasi Profile</h1>

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                        class="mt-1 p-2 `border border-blue-500 rounded w-full" readonly>
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        class="mt-1 p-2 border border-blue-500 rounded w-full" readonly>
                </div>

                <!-- Role Field -->
                <div class="mb-4">
                    <label for="peran" class="block text-sm font-medium text-gray-700">Peran</label>
                    <input type="text" name="peran" id="peran" value="{{ old('peran', auth()->user()->peran) }}"
                        class="mt-1 p-2 border border-blue-500 rounded w-full" readonly>
                </div>
                <div class="mb-4">
                    <label for="division_id" class="block text-sm font-medium text-gray-700">Role</label>
                    <input type="text" name="role" id="role"
                           value="{{ old('role', auth()->user()->roles[0]->name) }}"
                           class="mt-1 p-2 border border-blue-500 rounded w-full" readonly>
                </div>

            </div>
        </div>
    </div>
</x-dashboard-layout>
