<x-dashboard-layout title="Diagnosa Admin">

    <form id="filterForm" class="flex items-center mb-3 w-full lg:w-2/3" action="{{ route('diagnosa_admin.index') }}" method="GET">
        <div class="flex w-full space-x-3">
            <!-- Search Input -->
            <div class="relative flex-grow">
                <input
                    name="search"
                    type="text"
                    class="w-full pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 border border-blue-500 rounded-md"
                    placeholder="Search by Name..."
                    value="{{ request('search') }}"
                >
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fas fa-search"></i> <!-- FontAwesome search icon -->
                </span>
            </div>

            <!-- Peran Dropdown -->
            <div class="w-1/3">
                <select name="peran" class="w-full px-4 py-2 text-sm border border-blue-500 rounded-md">
                    <option value="">Select Peran</option>
                    <option value="Orang tua" {{ request('peran') == 'Orang tua' ? 'selected' : '' }}>Orang tua</option>
                    <option value="Suami" {{ request('peran') == 'Suami' ? 'selected' : '' }}>Suami</option>
                    <option value="Ibu" {{ request('peran') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                </select>
            </div>

            <!-- Kategori Dropdown -->
            <div class="w-1/3">
                <select name="kategori" class="w-full px-4 py-2 text-sm border border-blue-500 rounded-md">
                    <option value="">Select Kategori</option>
                    <option value="Tidak Ada Risiko Baby Blues" {{ request('kategori') == 'Tidak Ada Risiko Baby Blues' ? 'selected' : '' }}>Tidak Ada Risiko Baby Blues</option>
                    <option value="Risiko Rendah Baby Blues" {{ request('kategori') == 'Risiko Rendah Baby Blues' ? 'selected' : '' }}>Risiko Rendah Baby Blues</option>
                    <option value="Risiko Sedang Baby Blues" {{ request('kategori') == 'Risiko Sedang Baby Blues' ? 'selected' : '' }}>Risiko Sedang Baby Blues</option>
                    <option value="Risiko Tinggi Baby Blues" {{ request('kategori') == 'Risiko Tinggi Baby Blues' ? 'selected' : '' }}>Risiko Tinggi Baby Blues</option>
                </select>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const inputs = form.querySelectorAll('input, select');

            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    form.submit();
                });
            });
        });
    </script>


    @if ($diagnosas->isNotEmpty())
    <div class="w-full overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-400 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4 text-white text-left">No.</th>
                    <th class="py-3 px-4 text-white text-left">Nama</th>
                    <th class="py-3 px-4 text-white text-left">Peran</th>
                    <th class="py-3 px-4 text-white text-left">Hasil</th>
                    <th class="py-3 px-4 text-white text-left">Tanggal</th>
                    <th class="py-3 px-4 text-white text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($diagnosas as $index => $diagnosa)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-4 text-left whitespace-nowrap">
                            {{ $diagnosas->firstItem() + $index }}
                        </td>
                        <td class="py-3 px-4 text-left">
                            <div class="flex items-center">
                                {{ optional($diagnosa->user)->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="py-3 px-4 text-left">
                            {{ optional($diagnosa->user)->peran ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-4 text-left">
                            @php
                                $resultClasses = [
                                    'Tidak Ada Risiko Baby Blues' => 'bg-green-600',
                                    'Risiko Rendah Baby Blues' => 'bg-blue-600',
                                    'Risiko Sedang Baby Blues' => 'bg-yellow-500',
                                    'Risiko Tinggi Baby Blues' => 'bg-red-600'
                                ];
                                $class = $resultClasses[$diagnosa->hasil] ?? 'bg-gray-500';
                            @endphp
                            <span class="rounded px-2 py-1 text-white font-semibold {{ $class }}">
                                {{ $diagnosa->hasil }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-left">
                            {{ date('d M Y H:i', strtotime($diagnosa->created_at)) }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('diagnosa_admin.show', $diagnosa->id) }}"
                                   class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-md transform hover:bg-blue-600 hover:scale-110">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>
                                <button id="btn-modal-delete-{{ $diagnosa->id }}"
                                        class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded-md transform hover:bg-red-600 hover:scale-110">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <div id="modal-{{ $diagnosa->id }}" class="fixed top-0 hidden flex items-center justify-center right-0 w-full h-screen bg-gray-900 bg-opacity-80 z-[99999]">
                                <div class="bg-white w-[30rem] p-6 rounded-lg opacity-100 flex items-center justify-center flex-col gap-5">
                                    <i class="fa-solid fa-circle-exclamation text-5xl text-red-500"></i>
                                    <p>Are you sure you want to <span class="font-bold">delete</span> this diagnosa record?</p>
                                    <div class="flex items-center gap-6">
                                        <button id="cancel-btn-{{ $diagnosa->id }}" type="button"
                                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('diagnosa_admin.destroy', $diagnosa->id) }}" method="POST">
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
                                const modal{{ $diagnosa->id }} = document.getElementById('modal-{{ $diagnosa->id }}')
                                const cancelBtn{{ $diagnosa->id }} = document.getElementById('cancel-btn-{{ $diagnosa->id }}')
                                const openModal{{ $diagnosa->id }} = document.getElementById('btn-modal-delete-{{ $diagnosa->id }}')

                                // Show modal when the delete button is clicked
                                openModal{{ $diagnosa->id }}.addEventListener('click', () => {
                                    modal{{ $diagnosa->id }}.classList.toggle('hidden')
                                })

                                // Hide modal when cancel button is clicked
                                cancelBtn{{ $diagnosa->id }}.addEventListener('click', () => {
                                    modal{{ $diagnosa->id }}.classList.toggle('hidden')
                                })
                            </script>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        @if ($diagnosas->total() > 10)
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 justify-between sm:hidden">
                    {{-- Mobile View: Previous Page Link --}}
                    @if ($diagnosas->onFirstPage())
                        <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $diagnosas->previousPageUrl() }}"
                        class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                    @endif

                    {{-- Mobile View: Next Page Link --}}
                    @if ($diagnosas->hasMorePages())
                        <a href="{{ $diagnosas->nextPageUrl() }}"
                        class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Next</span>
                    @endif
                </div>

                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $diagnosas->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $diagnosas->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $diagnosas->total() }}</span>
                            results
                        </p>
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Previous Button --}}
                        @if ($diagnosas->onFirstPage())
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
                            <a href="{{ $diagnosas->previousPageUrl() }}"
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
                            @foreach (range(max(1, $diagnosas->currentPage() - 2), min($diagnosas->lastPage(), $diagnosas->currentPage() + 2)) as $page)
                                @if ($page == $diagnosas->currentPage())
                                    <span aria-current="page"
                                        class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $diagnosas->url($page) }}"
                                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Button --}}
                        @if ($diagnosas->hasMorePages())
                            <a href="{{ $diagnosas->nextPageUrl() }}"
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
            <p class="text-gray-500 mt-4 ">Tidak ada catatan diagnosis yang ditemukan.</p>
        </div>
    @endif
</x-dashboard-layout>
