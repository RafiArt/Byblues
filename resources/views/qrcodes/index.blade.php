<x-dashboard-layout title="Qrcode">
    <div class="w-full bg-white p-2 rounded-lg">
        <!-- QR Code Generation Form -->
        <form action="{{ route('qrcodes.store') }}" method="POST" class="relative">
            @csrf
            <div class="relative">
                <input type="text" name="link" required
                    class="w-full rounded font-medium placeholder:text-gray-400 text-1x1 px-3 lg:px-4 py-2 lg:py-3 bg-gray-100 outline-none border-none placeholder:font-medium"
                    placeholder="https://yourdomain.id/very-long-link">

                <button type="submit"
                    class="flex items-center gap-2 absolute right-1 top-1/2
                -translate-y-1/2 bg-blue-600 p-1 lg:p-2 px-2 lg:px-4 rounded hover:bg-blue-800 transition">
                    <i class="fa-solid fa-qrcode text-lg lg:text-xl text-white"></i>
                    <p class="text-white font-extrabold text-sm lg:text-base">
                        Generate
                    </p>
                </button>
            </div>
            @error('link')
                <p class="text-red-600 text-sm">*{{ $message }}</p>
            @enderror
        </form>
    </div>

    <!-- Latest Generated Barcodes Section -->
    <div class="w-full mt-6 flex flex-col lg:flex-row gap-2 lg:gap-0 lg:items-center justify-between">
        <h1 class="font-bold">Latest Generated Barcode</h1>
        <form action="{{ route('qrcodes.index') }}" method="GET" class="relative">
            <input type="text" class="w-full lg:w-[20rem] rounded border-gray-200 text-sm" name="search"
                placeholder="Search">
            <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-gray-300"></i>
        </form>
    </div>

    @if ($qrcodes->isNotEmpty())
        @foreach ($qrcodes as $qrcode)
            <div class="w-full mt-3 space-y-2">
                <div class="w-full bg-white rounded-lg">
                    <!-- QR Code Display Section -->
                    <div class="w-full p-3 border rounded-t-lg lg:flex items-center justify-between">
                        <div class="flex-1 flex items-center">
                            <h2 class="font-semibold text-lg lg:text-xl text-gray-900">{{ $qrcode->link }}</h2>
                        </div>
                        <div class="flex items-center gap-2 mt-1 lg:mt-0">
                            <!-- Open QR Code Modal Button -->
                            <button id="openModal"
                                class="flex items-center justify-center w-9 h-9 lg:w-10 lg:h-10 p-3 bg-blue-600 rounded hover:bg-blue-800 transition text-white text-xs lg:text-sm"
                                data-id="{{ $qrcode->id }}" data-link="{{ $qrcode->link }}"
                                data-qrcode="{{ base64_encode($qrcode->qrcode) }}" onclick="openQrCodeModal(this)">
                                <i class="fa-solid fa-qrcode"></i>
                            </button>
                            <!-- Download QR Code Button -->
                            {{-- <div id="downloadQR" class="text-center">
                            <button id="downloadButtonQrcode" class="flex items-center justify-center w-9 h-9 lg:w-10 lg:h-10 p-3 bg-blue-600 rounded hover:bg-blue-800 transition text-white text-xs lg:text-sm" onclick="downloadbuttonQrCode()">
                                <i class="fa fa-download"></i>
                            </button>
                        </div> --}}

                            @if (!$qrcode->shortlink_id)
                                <button type="submit" id="btn-modal-delete-{{ $qrcode->id }}"
                                    class="flex items-center justify-center w-9 h-9 lg:w-10 lg:h-10 p-3 bg-red-600 rounded hover:bg-red-800 transition text-white text-xs lg:text-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
            <div class="w-full bg-white p-4 border rounded-b-lg border-t-0 flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-gray-400 font-semibold">
                    <i class="fa-regular fa-calendar text-lg"></i>
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-normal text-gray-500">
                            {{ date('d M Y H:i', strtotime($qrcode->created_at)) }}</p>
                    </div>
                </div>
            </div>
            <x-qr-code-modal id="qrCodeModal" />

            <div id="modal-{{ $qrcode->id }}"
                class="fixed top-0 hidden flex items-center justify-center right-0 w-full h-screen bg-gray-900 bg-opacity-80 z-[99999]">
                <div class="bg-white w-[30rem] p-6 rounded-lg opacity-100 flex items-center justify-center flex-col gap-5">
                    <i class="fa-solid fa-circle-exclamation text-5xl text-red-500"></i>
                    <p>Are you sure you want to <span class="font-bold">delete</span> this QR code?</p>
                    <div class="flex items-center gap-6">
                        <button id="cancel-btn-{{ $qrcode->id }}" type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>

                        <form action="{{ route('qrcodes.destroy', $qrcode->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">Delete</button>
                        </form>
                    </div>
                </div>

            </div>

            <script>
                const modal{{ $qrcode->id }} = document.getElementById('modal-{{ $qrcode->id }}')
                const cancelBtn{{ $qrcode->id }} = document.getElementById('cancel-btn-{{ $qrcode->id }}')
                const openModal{{ $qrcode->id }} = document.getElementById('btn-modal-delete-{{ $qrcode->id }}')
                // const downloadButtonQrcode = document.getElementById('downloadButtonQrcode')

                openModal{{ $qrcode->id }}.addEventListener('click', () => {
                    modal{{ $qrcode->id }}.classList.toggle('hidden')
                })

                cancelBtn{{ $qrcode->id }}.addEventListener('click', () => {
                    modal{{ $qrcode->id }}.classList.toggle('hidden')
                })
            </script>
        @endforeach

        @if ($qrcodes->total() > 10)
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex flex-1 justify-between sm:hidden">
                    {{-- Mobile View: Previous Page Link --}}
                    @if ($qrcodes->onFirstPage())
                        <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $qrcodes->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                    @endif

                    {{-- Mobile View: Next Page Link --}}
                    @if ($qrcodes->hasMorePages())
                        <a href="{{ $qrcodes->nextPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Next</span>
                    @endif
                </div>

                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $qrcodes->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $qrcodes->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $qrcodes->total() }}</span>
                            results
                        </p>
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Previous Button --}}
                        @if ($qrcodes->onFirstPage())
                            <span class="cursor-not-allowed opacity-50">
                                <button type="button" disabled class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 cursor-not-allowed">
                                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Previous
                                </button>
                            </span>
                        @else
                            <a href="{{ $qrcodes->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Previous
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        <div class="flex space-x-1">
                            @foreach(range(
                                max(1, $qrcodes->currentPage() - 2),
                                min($qrcodes->lastPage(), $qrcodes->currentPage() + 2)
                            ) as $page)
                                @if ($page == $qrcodes->currentPage())
                                    <span aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $qrcodes->url($page) }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Button --}}
                        @if ($qrcodes->hasMorePages())
                            <a href="{{ $qrcodes->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
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
                    <video autoplay loop muted playsinline class="w-64 h-64" style="background-color: transparent;">
                        <source src="{{ asset('video/vid2-rm.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <p class="text-gray-500 mt-4 ">Tidak ada barcode yang ditemukan.</p>
        </div>
    @endif

</x-dashboard-layout>
