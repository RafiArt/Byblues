@props(['id', 'userId' => null, 'roles' => [], 'user' => null])

<div id="{{ $id . '-' . $userId }}"
    class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96 relative">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Edit User</h3>
            <button type="button" onclick="closeModal('{{ $id . '-' . $userId }}')"
                class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('admin.user.update', ['user' => $userId]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="role-{{ $userId }}" class="block text-sm font-medium text-gray-700 mb-2">Select
                    Role</label>
                <select name="role" id="role-{{ $userId }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <!-- Opsi default -->
                    <option value="" disabled {{ optional($user->roles->first())->name ? '' : 'selected' }}>
                        Select a role
                    </option>
                    <!-- Opsi roles dari database -->
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ $user && $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal('{{ $id . '-' . $userId }}')"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
</script>
