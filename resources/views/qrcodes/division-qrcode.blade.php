<x-dashboard-layout title="Division QR Code">
    <!-- Latest Generated Barcodes Section -->
    <div class="w-full mt-6 flex flex-col lg:flex-row gap-2 lg:gap-0 lg:items-center justify-between">
        <h1 class="font-bold">Latest Generated Barcode Division</h1>
        <form action="{{ route('qrcodes.divisionQR') }}" method="GET" class="relative">
            <input type="text" class="w-full lg:w-[20rem] rounded border-gray-200 text-sm" name="search"
                   placeholder="Search">
            <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-gray-300"></i>
        </form>
    </div>

    @if ($qrcodesDivisions->isEmpty())
        <div class="bg-gray-100 p-8 text-center">
            <div class="bg-transparent mx-auto w-full max-w-xs rounded overflow-hidden">
                <video autoplay loop muted playsinline class="w-full" style="background-color: transparent;">
                    <source src="{{ asset('video/vid2-rm.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

            </div>
            <p class="text-gray-500 mt-4 text-xl">Tidak ada barcode division yang ditemukan.</p>
        </div>
    @else
        @foreach ($qrcodesDivisions as $qrcodesDivision)
            <div class="w-full mt-3 space-y-2">
                <div class="w-full bg-white rounded-lg">
                    <!-- QR Code Display Section -->
                    <div class="w-full p-3 border rounded-t-lg lg:flex items-center justify-between">
                        <div class="flex-1 flex items-center">
                            <h2 class="font-semibold text-lg lg:text-xl text-gray-900">{{ $qrcodesDivision->link }}</h2>
                        </div>
                        <div class="flex items-center gap-2 mt-4 lg:mt-0">
                            <!-- Open QR Code Modal Button -->
                            <button id="openModal"
                                class="flex items-center justify-center w-9 h-9 lg:w-10 lg:h-10 p-3 bg-blue-600 rounded hover:bg-blue-800 transition text-white text-xs lg:text-sm"
                                data-id="{{ $qrcodesDivision->id }}"
                                data-link="{{ $qrcodesDivision->link }}"
                                data-qrcode="{{ base64_encode($qrcodesDivision->qrcode) }}"
                                onclick="openQrCodeModal(this)">
                                <i class="fa-solid fa-qrcode"></i>
                            </button>

                        </div>
                    </div>


                </div>
            </div>
            <div class="w-full bg-white p-4 border rounded-b-lg border-t-0 flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-gray-400 font-semibold">
                    <i class="fa-regular fa-calendar text-lg"></i>
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-normal text-gray-500">
                            {{ date('d M Y H:i', strtotime($qrcodesDivision->created_at)) }} <!-- Tanggal pembuatan -->
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-user text-lg"></i> <!-- Ikon untuk menunjukkan pembuat -->
                        <p class="text-sm font-normal text-gray-500">
                            {{ $qrcodesDivision->user->name }} <!-- Menampilkan nama pembuat -->
                        </p>
                    </div>
                </div>
            </div>
            <x-qr-code-modal id="qrCodeModal" />
        @endforeach
        @if ($qrcodesDivisions->total() > 10)
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 justify-between sm:hidden">
                    {{-- Mobile View: Previous Page Link --}}
                    @if ($qrcodesDivisions->onFirstPage())
                        <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $qrcodesDivisions->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                    @endif

                    {{-- Mobile View: Next Page Link --}}
                    @if ($qrcodesDivisions->hasMorePages())
                        <a href="{{ $qrcodesDivisions->nextPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Next</span>
                    @endif
                </div>

                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $qrcodesDivisions->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $qrcodesDivisions->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $qrcodesDivisions->total() }}</span>
                            results
                        </p>
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Previous Button --}}
                        @if ($qrcodesDivisions->onFirstPage())
                            <span class="cursor-not-allowed opacity-50">
                                <button type="button" disabled class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 cursor-not-allowed">
                                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Previous
                                </button>
                            </span>
                        @else
                            <a href="{{ $qrcodesDivisions->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Previous
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        <div class="flex space-x-1">
                            @foreach(range(
                                max(1, $qrcodesDivisions->currentPage() - 2),
                                min($qrcodesDivisions->lastPage(), $qrcodesDivisions->currentPage() + 2)
                            ) as $page)
                                @if ($page == $qrcodesDivisions->currentPage())
                                    <span aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $qrcodesDivisions->url($page) }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Button --}}
                        @if ($qrcodesDivisions->hasMorePages())
                            <a href="{{ $qrcodesDivisions->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                                <svg class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="cursor-not-allowed opacity-50">
                                <button type="button" disabled class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 cursor-not-allowed">
                                    Next
                                    <svg class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010-1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    @endif
</x-dashboard-layout>
