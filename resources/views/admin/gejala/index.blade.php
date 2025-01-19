<x-dashboard-layout title="Gejala">
        <!-- Search Form -->
        <form class="flex items-center mb-3 w-full lg:w-2/3" action="{{ route('gejala.index') }}" method="GET">
            <div class="flex w-full space-x-3">
                <!-- Search Input -->
                <div class="relative w-full"> <!-- Set w-full here -->
                    <input name="search" type="text"
                           class="w-full pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 border border-blue-500 rounded-md"
                           placeholder="Search Gejala..."
                           value="{{ old('search', $search ?? '') }}">
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="fas fa-search"></i> <!-- FontAwesome search icon -->
                    </span>
                </div>

                <!-- Category Dropdown -->
                <div class="w-full"> <!-- Set w-full here -->
                    <select name="kategori" class="w-full px-4 py-2 text-sm border border-blue-500 rounded-md" onchange="this.form.submit()">
                        <option value="">Select Kategori</option>
                        <option value="Kesejahteraan Emosional" {{ old('kategori', $kategori) == 'Kesejahteraan Emosional' ? 'selected' : '' }}>Kesejahteraan Emosional</option>
                        <option value="Kesejahteraan Fisik" {{ old('kategori', $kategori) == 'Kesejahteraan Fisik' ? 'selected' : '' }}>Kesejahteraan Fisik</option>
                        <option value="Hubungan Sosial" {{ old('kategori', $kategori) == 'Hubungan Sosial' ? 'selected' : '' }}>Hubungan Sosial</option>
                        <option value="Peran dan Dukungan Keluarga" {{ old('kategori', $kategori) == 'Peran dan Dukungan Keluarga' ? 'selected' : '' }}>Peran dan Dukungan Keluarga</option>
                    </select>
                </div>

                <!-- Peran Dropdown -->
                <div class="w-full"> <!-- Set w-full here -->
                    <select name="peran" class="w-full px-4 py-2 text-sm border border-blue-500 rounded-md" onchange="this.form.submit()">
                        <option value="">Select Peran</option>
                        <option value="Orang tua" {{ old('peran', $peran) == 'Orang tua' ? 'selected' : '' }}>Orang tua</option>
                        <option value="Suami" {{ old('peran', $peran) == 'Suami' ? 'selected' : '' }}>Suami</option>
                        <option value="Ibu" {{ old('peran', $peran) == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                    </select>
                </div>
            </div>
        </form>


        <!-- Add New gejalas Button -->
        <button type="button"
                data-modal-target="addGejalaModal"
                data-modal-toggle="addGejalaModal"
                class="inline-block px-6 py-2 mb-3 text-white bg-green-500 rounded-md hover:bg-green-600">
            <span class="font-semibold">Tambah Gejala</span>
            <i class="fa-solid fa-plus text-lg text-white ml-2"></i>
        </button>

        {{-- @if (session('error'))
            <div id="alert-error"
                class="bg-red-600 shadow-lg text-white px-6 py-2 absolute right-6 bottom-6 z-[99999] rounded-lg">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-4">
                        <i class="fa-regular fa-circle-check text-2xl"></i>
                        <p class="font-medium mr-14">{{ session('error') }}</p>
                    </div>
                    <i class="fa-solid fa-xmark text-xl p-2 cursor-pointer hover:text-gray-200 transition"
                        id="close-error-alert"></i>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const alertError = document.getElementById('alert-error');
                    const closeErrorAlert = document.getElementById('close-error-alert');

                    // Auto-hide the alert after 3 seconds
                    setTimeout(function() {
                        if (alertError) {
                            alertError.style.display = 'none';
                        }
                    }, 3000);

                    // Close the alert when the "X" button is clicked
                    if (closeErrorAlert) {
                        closeErrorAlert.addEventListener('click', function() {
                            if (alertError) {
                                alertError.style.display = 'none';
                            }
                        });
                    }
                });
            </script>
        @endif

        @if (session('success'))
            <div id="alert-success"
                class="bg-green-500 shadow-lg text-white px-6 py-2 absolute right-6 bottom-6 z-[99999] rounded-lg">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-4">
                        <i class="fa-regular fa-circle-check text-2xl"></i>
                        <p class="font-medium mr-14">{{ session('success') }}</p>
                    </div>
                    <i class="fa-solid fa-xmark text-xl p-2 cursor-pointer hover:text-gray-200 transition"
                        id="close-success-alert"></i>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const alertSuccess = document.getElementById('alert-success');
                    const closeSuccessAlert = document.getElementById('close-success-alert');

                    // Auto-hide the alert after 3 seconds
                    setTimeout(function() {
                        if (alertSuccess) {
                            alertSuccess.style.display = 'none';
                        }
                    }, 3000);

                    // Close the alert when the "X" button is clicked
                    if (closeSuccessAlert) {
                        closeSuccessAlert.addEventListener('click', function() {
                            if (alertSuccess) {
                                alertSuccess.style.display = 'none';
                            }
                        });
                    }
                });
            </script>
        @endif --}}



        @if ($gejalas->isNotEmpty())
            <div class="w-full overflow-x-auto">
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-400 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-4 text-white text-left">No.</th>
                            <th class="py-3 px-4 text-white text-left">Kode</th>
                            <th class="py-3 px-4 text-white text-left">Keterangan</th>
                            <th class="py-3 px-4 text-white text-left">Kategori</th>
                            <th class="py-3 px-4 text-white text-center">Peran</th>
                            <th class="py-3 px-4 text-white text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($gejalas as $index => $gejala)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4 text-left whitespace-nowrap">
                                    {{ $gejalas->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-4 text-left">
                                    {{ $gejala->kode }}
                                </td>
                                <td class="py-3 px-4 text-left">
                                    {{ $gejala->keterangan }}
                                </td>
                                <td class="py-3 px-4 text-left">
                                    {{ $gejala->kategori }}
                                </td>
                                <td class="py-3 px-4 text-left">
                                    {{ $gejala->peran }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button data-modal-target="editGejalaModal{{ $gejala->id }}"
                                                data-modal-toggle="editGejalaModal{{ $gejala->id }}"
                                                class="w-8 h-8 flex items-center justify-center bg-yellow-500 text-white rounded-md transform hover:bg-yellow-600 hover:scale-110">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <x-edit-gejala-modal :id="'editGejalaModal' . $gejala->id" :gejala="$gejala" />
                                        <button id="btn-modal-delete-{{ $gejala->id }}"
                                            class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded-md transform hover:bg-red-600 hover:scale-110">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                        <div id="modal-{{ $gejala->id }}" class="fixed top-0 hidden flex items-center justify-center right-0 w-full h-screen bg-gray-900 bg-opacity-80 z-[99999]">
                                            <div class="bg-white w-[30rem] p-6 rounded-lg opacity-100 flex items-center justify-center flex-col gap-5">
                                                <i class="fa-solid fa-circle-exclamation text-5xl text-red-500"></i>
                                                <p>Are you sure you want to <span class="font-bold">delete</span> this gejala record?</p>
                                                <div class="flex items-center gap-6">
                                                    <button id="cancel-btn-{{ $gejala->id }}" type="button"
                                                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>

                                                    <!-- Delete Form -->
                                                    <form action="{{ route('gejala.destroy', $gejala->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- JavaScript to handle modal visibility -->
                                        <script>
                                            const modal{{ $gejala->id }} = document.getElementById('modal-{{ $gejala->id }}')
                                            const cancelBtn{{ $gejala->id }} = document.getElementById('cancel-btn-{{ $gejala->id }}')
                                            const openModal{{ $gejala->id }} = document.getElementById('btn-modal-delete-{{ $gejala->id }}')

                                            // Show modal when the delete button is clicked
                                            openModal{{ $gejala->id }}.addEventListener('click', () => {
                                                modal{{ $gejala->id }}.classList.toggle('hidden')
                                            })

                                            // Hide modal when cancel button is clicked
                                            cancelBtn{{ $gejala->id }}.addEventListener('click', () => {
                                                modal{{ $gejala->id }}.classList.toggle('hidden')
                                            })
                                        </script>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($gejalas->total() > 10)
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <div class="flex flex-1 justify-between sm:hidden">
                        {{-- Mobile View: Previous Page Link --}}
                        @if ($gejalas->onFirstPage())
                            <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $gejalas->previousPageUrl() }}"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                        @endif

                        {{-- Mobile View: Next Page Link --}}
                        @if ($gejalas->hasMorePages())
                            <a href="{{ $gejalas->nextPageUrl() }}"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                        @else
                            <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Next</span>
                        @endif
                    </div>

                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $gejalas->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $gejalas->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $gejalas->total() }}</span>
                                results
                            </p>
                        </div>

                        <div class="flex items-center space-x-2">
                            {{-- Previous Button --}}
                            @if ($gejalas->onFirstPage())
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
                                <a href="{{ $gejalas->previousPageUrl() }}"
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
                                @foreach (range(max(1, $gejalas->currentPage() - 2), min($gejalas->lastPage(), $gejalas->currentPage() + 2)) as $page)
                                    @if ($page == $gejalas->currentPage())
                                        <span aria-current="page"
                                            class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $gejalas->url($page) }}"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Next Button --}}
                            @if ($gejalas->hasMorePages())
                                <a href="{{ $gejalas->nextPageUrl() }}"
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
        @else
                <div class="bg-gray-100 p-8 text-center">
                    <div class="bg-transparent mx-auto w-full max-w-xs rounded overflow-hidden">
                        <div class="flex justify-center">
                            <video autoplay loop muted playsinline class="w-64 h-64"
                                style="background-color: transparent;">
                                <source src="{{ asset('video/vid2-rm.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    <p class="text-gray-500 mt-4 ">Tidak ada gejala yang ditambahkan.</p>
                </div>
        @endif
    <x-add-gejala-modal id="addGejalaModal" />


</x-dashboard-layout>
