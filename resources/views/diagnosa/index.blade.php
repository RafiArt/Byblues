<x-dashboard-layout title="Diagnosis">

    <!-- Search Form -->
    <form class="flex items-center mb-3" action="{{ route('diagnosa.index') }}" method="GET">
        <div class="flex w-full max-w-sm border border-blue-500 rounded-md overflow-hidden">
            <input name="search" type="text"
                class="flex-grow px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 border-none"
                placeholder="Search Diagnosis..."
                value="{{ old('search', $search ?? '') }}">
            <button type="submit"
                class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600">
                Search
            </button>
        </div>
    </form>

    <!-- Add New Diagnosis Button -->
    <a href="{{route('diagnosa.create')}}" class="inline-block px-6 py-2 mb-3 text-white bg-green-500 rounded-md hover:bg-green-600">
        <span class="font-semibold">Diagnosis</span>
        <i class="fa-solid fa-plus text-lg text-white ml-2"></i>
    </a>

    @if ($diagnosas->isNotEmpty())
        @foreach ($diagnosas as $diagnosa)
            <div class="w-full mt-3 space-y-2">
                <!-- Card Wrapper -->
                <div class="w-full bg-white rounded-lg shadow-lg">
                    <!-- Header Section -->
                    <div class="w-full p-4 border-b rounded-t-lg flex items-center justify-between">
                        <div class="flex-1 flex items-center">
                            <h2 class="font-semibold text-lg lg:text-xl text-gray-900">Diagnosis Details</h2>
                        </div>
                        <!-- Download Button Section -->
                        <div class="flex items-center gap-1">
                            <button class="flex items-center gap-2 p-1 px-2 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm">
                                <i class="fa-solid fa-circle-info text-lg"></i>
                                <p class="hidden lg:block">Details</p>
                            </button>

                            <button class="flex items-center gap-2 p-1 px-2 bg-blue-500 rounded hover:bg-blue-600 hover:text-white text-xs lg:text-sm">
                                <i class="fa-solid fa-download text-white text-lg"></i> <!-- Icon download with white color -->
                            </button>


                        </div>
                    </div>

                    <!-- Body Section with CF Value and Hasil -->
                    <div class="p-4">
                        <div>
                            <p class="text-gray-700 font-semibold text-sm">Hasil: <span class="text-green-600">{{ $diagnosa->hasil }}</span></p>
                        </div>
                    </div>

                    <!-- Footer Section with Date -->
                    <div class="w-full bg-gray-50 p-4 border-t flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm text-gray-400 font-semibold">
                            <i class="fa-regular fa-calendar text-lg"></i>
                            <p class="text-sm font-normal text-gray-500">
                                {{ date('d M Y H:i', strtotime($diagnosa->created_at)) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

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
