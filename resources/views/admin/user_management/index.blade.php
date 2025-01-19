<x-dashboard-layout title="User Management">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
            <thead class="text-xs text-white uppercase bg-blue-600">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('admin.user.index', ['sort' => 'name', 'direction' => $sortColumn == 'name' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                            class="hover:underline">
                            Name
                            @if ($sortColumn == 'name')
                                <i class="ml-1 fa-solid fa-arrow-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('admin.user.index', ['sort' => 'email', 'direction' => $sortColumn == 'email' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                            class="hover:underline">
                            Email
                            @if ($sortColumn == 'email')
                                <i class="ml-1 fa-solid fa-arrow-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('admin.user.index', ['sort' => 'peran', 'direction' => $sortColumn == 'peran' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                            class="hover:underline">
                            Peran
                            @if ($sortColumn == 'peran')
                                <i class="ml-1 fa-solid fa-arrow-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('admin.user.index', ['sort' => 'role', 'direction' => $sortColumn == 'role' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}"
                            class="hover:underline">
                            Role
                            @if ($sortColumn == 'role')
                                <i class="ml-1 fa-solid fa-arrow-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="odd:bg-white even:bg-gray-50 border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->peran}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->roles[0]->name }}
                        </td>
                        <td class="px-6 py-4">
                            <!-- Button untuk membuka modal -->
                            <button onclick="openModal('modalRoles-{{ $user->id }}')"
                                class="h-9 w-9 flex items-center justify-center rounded bg-yellow-500 hover:bg-yellow-600 text-white transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <x-edit-user-modal id="modalRoles" :userId="$user->id" :roles="$roles" :user="$user" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if ($users->total() > 10)
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 justify-between sm:hidden">
                    {{-- Mobile View: Previous Page Link --}}
                    @if ($users->onFirstPage())
                        <span
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                    @endif

                    {{-- Mobile View: Next Page Link --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                    @else
                        <span
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Next</span>
                    @endif
                </div>

                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $users->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $users->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $users->total() }}</span>
                            results
                        </p>
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Previous Button --}}
                        @if ($users->onFirstPage())
                            <span class="cursor-not-allowed opacity-50">
                                <button type="button" disabled
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 cursor-not-allowed">
                                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Previous
                                </button>
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Previous
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        <div class="flex space-x-1">
                            @foreach (range(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page)
                                @if ($page == $users->currentPage())
                                    <span aria-current="page"
                                        class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $users->url($page) }}"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Button --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                                <svg class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="cursor-not-allowed opacity-50">
                                <button type="button" disabled
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 cursor-not-allowed">
                                    Next
                                    <svg class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-dashboard-layout>
