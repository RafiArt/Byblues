{{-- @dd($links); --}}

@php
    use Carbon\Carbon;
@endphp
<x-dashboard-layout title="Links Admin">
    <div class="w-full mt-6 flex flex-col lg:flex-row gap-2 lg:gap-0 lg:items-center justify-between">
        <h1 class="font-bold">Latest Generated Links</h1>
        <div class="flex flex-col md:flex-row justify-end gap-4">
            <!-- Form Filter Division -->
            <form action="{{ route('links_admin.index') }}" method="GET" class="flex items-center gap-4">
                <select id="division-filter" name="division_id"
                    class="w-full lg:w-[20rem] rounded border-gray-200 text-sm">
                    <option value="">Select Division</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}"
                            {{ request('division_id') == $division->id ? 'selected' : '' }}>
                            {{ $division->name_divisions }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Form Search -->
            <form action="{{ route('links_admin.index') }}" method="GET" class="relative">
                <input type="text" class="w-full lg:w-[20rem] rounded border-gray-200 text-sm pl-4 pr-10"
                    id="search" name="search" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-gray-300"></i>
            </form>
        </div>

    </div>
    <div class="w-full mt-6 space-y-2">

        @if ($links->isNotEmpty()) <!-- Cek jika ada link -->
            @foreach ($links as $link)
                <!-- Gunakan unique di sini -->
                <div class="w-full bg-white rounded-lg relative"> <!-- Tambahkan class relative di sini -->
                    <div class="w-full p-4 border rounded-t-lg lg:flex items-start justify-between">
                        <div class="w-full overflow-hidden">
                            <h1 class="font-semibold mb-3 text-lg">{{ $link->title }}</h1>
                            <h3 onclick="salinTeksKeClipboard1('{{ env('APP_URL') . '/' . $link->short_url }}')"
                                class="text-lg lg:text-2xl font-semibold hover:decoration-black hover:underline hover:cursor-pointer text-blue-600">
                                {{ env('APP_NAME') }}<span
                                    class="text-black hover:cursor-pointer">{{env('APP_DOMAIN')}}/{{ $link->short_url }}</span>
                            </h3>
                            <p class="text-xs lg:text-sm text-gray-400 hover:underline hover:cursor-pointer">
                                {{ $link->original_url }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 mt-2 lg:mt-0">
                            <div>
                                <button id="button-share-{{ $link->id }}"
                                    class="flex items-center gap-2 p-2 px-3 bg-blue-600 rounded hover:bg-blue-800 transition text-white text-xs lg:text-sm"
                                    onclick="toggleDropdown(event, {{ $link->id }})">
                                    <i class="fa-solid fa-share-nodes"></i>
                                    <p class="hidden lg:block">Share</p>
                                </button>

                                <script>
                                    function toggleDropdown(event, linkId) {
                                        const dropdown = document.getElementById('share-admin-' + linkId);
                                        dropdown.classList.toggle('hidden');

                                        // Prevent the click event from bubbling up to the document
                                        event.stopPropagation();
                                    }

                                    function copyToClipboard(text) {
                                        navigator.clipboard.writeText(text).then(() => {
                                            alert('Link copied to clipboard!');
                                        }).catch(err => {
                                            console.error('Failed to copy: ', err);
                                        });
                                    }

                                    // Close dropdown if clicked outside
                                    document.addEventListener('click', function(event) {
                                        const dropdowns = document.querySelectorAll('[id^="share-admin-"]');
                                        dropdowns.forEach(dropdown => {
                                            if (!dropdown.classList.contains('hidden') && !dropdown.contains(event.target)) {
                                                dropdown.classList.add('hidden');
                                            }
                                        });
                                    });
                                </script>
                                <div id="share-admin-{{ $link->id }}"
                                    class="absolute hidden top-15 w-40 bg-white border rounded shadow-lg z-10"
                                    style="margin-top: 0;">
                                    <ul>
                                        <li class="flex flex-col items-start px-1 py-1">
                                            <div class="w-full hover:bg-gray-200 mb-2">
                                                <a href="https://twitter.com/share?url={{ urlencode(env('APP_URL') . '/' . $link->short_url) }}"
                                                    target="_blank" class="flex items-center px-2 py-1 w-full">
                                                    <i class="fab fa-twitter-square text-blue-500 fa-lg"></i>
                                                    <span class="ml-2">Twitter</span>
                                                </a>
                                            </div>
                                            <div class="w-full hover:bg-gray-200 mb-2">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(env('APP_URL') . '/' . $link->short_url) }}"
                                                    target="_blank" class="flex items-center px-2 py-1 w-full">
                                                    <i class="fab fa-facebook-square text-blue-500 fa-lg"></i>
                                                    <span class="ml-2">Facebook</span>
                                                </a>
                                            </div>
                                            <div class="w-full hover:bg-gray-200 mb-2">
                                                <a href="whatsapp://send?text={{ urlencode(env('APP_URL') . '/' . $link->short_url) }}"
                                                    target="_blank" class="flex items-center px-2 py-1 w-full">
                                                    <i class="fab fa-whatsapp-square text-green-500 fa-lg"></i>
                                                    <span class="ml-2">WhatsApp</span>
                                                </a>
                                            </div>
                                            <div class="w-full hover:bg-gray-200">
                                                <a href="#"
                                                    onclick="copyToClipboard('{{ env('APP_URL') . '/' . $link->short_url }}'); return false;"
                                                    class="flex items-center px-2 py-1 w-full">
                                                    <i class="fas fa-copy text-gray-500 fa-lg"></i>
                                                    <span class="ml-2">Copy</span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @foreach ($link->qrcodes as $qrcode)
                                <!-- Iterasi untuk setiap QR code terkait -->
                                <button id="openModal"
                                    class="flex items-center justify-center gap-2 p-2 px-3 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm"
                                    data-id="{{ $qrcode->id }}" data-link="{{ $qrcode->link }}"
                                    data-qrcode="{{ base64_encode($qrcode->qrcode) }}" onclick="openQrCodeModal(this)">
                                    <i class="fa-solid fa-qrcode"></i>
                                    <p class="hidden lg:block">QR</p>
                                </button>
                            @endforeach
                            <a href="{{ route('links_admin.edit', $link->id) }}"
                                class="flex items-center gap-2 p-2 px-3 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <p class="hidden lg:block">Edit</p>
                            </a>
                            <div class="block lg:hidden">
                                <button
                                    class="accordion-button flex items-center gap-2 p-2 px-3 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm"
                                    data-id="{{ $link->id }}">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    <p class="hidden lg:block">Statistik</p>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="w-full bg-white p-4 border rounded-b-lg border-t-0 flex items-center justify-between">
                        <div class="flex items-center gap-4 text-sm text-gray-400 font-semibold">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar"></i>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-normal text-gray-500">
                                        {{ date('d M Y H:i', strtotime($link->created_at)) }}
                                        <!-- Tanggal pembuatan -->
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user"></i> <!-- Ikon untuk menunjukkan pembuat -->
                                <p class="text-sm font-normal text-gray-500">
                                    {{ $link->user->name }} <!-- Menampilkan nama pembuat -->
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-building"></i>
                                <!-- Ikon gedung untuk menunjukkan perusahaan -->
                                <p class="text-sm font-normal text-gray-500">
                                    {{ $link->user->division ? $link->user->division->name_divisions : 'Guest' }}
                                    <!-- Menampilkan nama divisi atau 'Guest' jika null -->
                                </p>
                            </div>
                        </div>
                        <div class="w-fit flex items-center gap-2">
                            @if ($link->expiration_date && $link->expiration_date > now())
                                <button disabled id="set-time-btn-{{ $link->id }}" title="Time-based Link"
                                    class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-green-100 rounded hover:bg-green-200 transition text-green-600 text-xs lg:text-sm hidden lg:block">
                                    <div class="flex items-center justify-between w-full">
                                        <i class="fa-solid fa-clock"></i>
                                        <p class="ml-1 mb-0"> <!-- Ubah margin untuk mengurangi jarak -->
                                            {{ date('d F Y, H:i', strtotime($link->expiration_date)) }}
                                        </p>
                                    </div>
                                </button>
                            @elseif ($link->expiration_date && $link->expiration_date < now())
                                <button disabled id="set-time-btn-{{ $link->id }}" title="Time-based Link"
                                    class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-red-200 rounded hover:bg-blue-600 hover:text-white transition text-red-700 text-xs lg:text-sm hidden lg:block">
                                    <div class="flex items-center justify-between w-full">
                                        <i class="fa-solid fa-clock"></i>
                                        <p class="ml-1 mb-0">Expired</p> <!-- Ubah margin untuk mengurangi jarak -->
                                    </div>
                                </button>
                            @else
                                <button disabled id="set-time-btn-{{ $link->id }}" title="Time-based Link"
                                    class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-gray-300 rounded transition text-gray-700 text-xs lg:text-sm hidden lg:block">
                                    <div class="flex items-center justify-between w-full">
                                        <i class="fa-solid fa-clock"></i>
                                        <p class="ml-1 mb-0">Time not set</p>
                                        <!-- Ubah margin untuk mengurangi jarak -->
                                    </div>
                                </button>
                            @endif

                            @if ($link->password)
                                <button disabled id="pashphraseBtn-{{ $link->id }}" title="Protected Link"
                                    class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-blue-100 rounded hover:bg-blue-200 text-blue-600 transition text-xs lg:text-sm hidden lg:block">
                                    <div class="flex items-center justify-between w-full">
                                        <i class="fa-solid fa-lock"></i>
                                        <p class="ml-1 mb-0">Locked</p> <!-- Ubah margin untuk mengurangi jarak -->
                                    </div>
                                </button>
                            @else
                                <button disabled id="pashphraseBtn-{{ $link->id }}" title="Protected Link"
                                    class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-gray-300 rounded transition text-gray-700 text-xs lg:text-sm hidden lg:block">
                                    <div class="flex items-center justify-between w-full">
                                        <i class="fa-solid fa-lock-open"></i>
                                        <p class="ml-1 mb-0">No Password</p>
                                        <!-- Ubah margin untuk mengurangi jarak -->
                                    </div>
                                </button>
                            @endif

                            <button
                                class="accordion-button flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm hidden lg:block"
                                data-id="{{ $link->id }}">
                                <div class="flex items-center justify-between w-full">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    <p class="ml-1 mb-0">Statistik</p> <!-- Ubah margin untuk mengurangi jarak -->
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="accordion-content hidden w-full mt-2" data-id="{{ $link->id }}">
                        <div class="chart-container">
                            <div class="container mx-auto lg:p-4 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-semibold">Statistik:</span>
                                </div>

                                {{-- Simpan data dalam input hidden --}}
                                <input type="hidden" id="visitorsData"
                                    value="{{ json_encode($formattedVisitorsData) }}">
                                <input type="hidden" id="uniqueVisitorsData"
                                    value="{{ json_encode($formattedUniqueVisitorsData) }}">
                                <input type="hidden" id="labels" value="{{ json_encode($labels) }}">

                                {{-- Chart container --}}
                                <div
                                    class="border-b-2 rounded h-64 flex items-center justify-start overflow-x-auto w-full">
                                    <div class="text-center min-w-[1150px]">
                                        <canvas id="chart-{{ $link->id }}" width="1150"
                                            height="250"></canvas>
                                    </div>
                                </div>
                                <div class="mt-4 flex overflow-x-auto w-full pb-4">
                                    <div
                                        class="flex-shrink-0 flex flex-col items-center min-w-[150px] border-l border-gray-300">
                                        <p class="text-2xl font-semibold">{{ $link->clicks }}</p>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                                            Visitors
                                        </p>
                                    </div>
                                    <div
                                        class="flex-shrink-0 flex flex-col items-center min-w-[150px] border-l border-gray-300">
                                        @php
                                            $visitorsData = $formattedUniqueVisitorsData[$link->id] ?? [];
                                        @endphp
                                        <p class="text-2xl font-semibold">
                                            @if (!empty($visitorsData))
                                                {{ end($visitorsData) }}
                                            @else
                                                0
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-1"></span>
                                            Unique Visitors
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="time-based-modal-{{ $loop->iteration }}"
                        class="w-full hidden h-screen bg-gray-800 bg-opacity-30 flex items-center justify-center fixed top-0 right-0 z-[9999] !mt-0">
                        <div class="w-[30rem] bg-white p-4 shadow-lg rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-2 items-center">
                                    <i class="fa-solid fa-clock text-lg"></i>
                                    <p class="font-semibold text-xl">Time-based Link</p>

                                </div>
                                <buton id="closeTimeModal-{{ $loop->iteration }}"
                                    class="h-8 w-8  flex items-center justify-center">
                                    <i class="fa-solid fa-xmark text-2xl hover:cursor-pointer"></i>
                                </buton>
                            </div>
                            <div class="w-full flex items-start p-2 border gap-2 bg-gray-100 mt-3">
                                <i class="fa-solid fa-circle-info text-sm mt-1"></i>
                                <p class="text-sm">A time-based link only lasts for a certain period of time. When it
                                    expires,
                                    it will
                                    no longer be
                                    accessible.</p>
                            </div>
                            <form action="{{ route('links.updateExpired', $link->id) }}" method="POST"
                                class="mt-3">
                                @csrf
                                @method('put')
                                <div class="flex flex-col space-y-2">
                                    <label for="" class="font-semibold text-sm">Date & Time</label>
                                    <input type="datetime-local" name="expiration_date"
                                        class="placeholder:text-gray-400 border-gray-300 rounded-lg">
                                </div>

                                <i class="text-sm text-gray-800 mt-2">*Date & Time based on browser time.</i>
                                <div
                                    class="flex items-center @if ($link->expiration_date && $link->expiration_date != null) justify-between @else justify-end @endif  gap-3 mt-5 text-sm">
                                    @if ($link->expiration_date && $link->expiration_date != null)
                                        <button type="submit"
                                            formaction="{{ route('links.removeExpirationDate', $link->id) }}"
                                            class="py-2 px-4 rounded-lg font-medium  bg-red-600 hover:bg-red-700 text-white transition">Remove
                                            it</button>
                                    @endif
                                    <div class="flex items-center justify-end gap-3">
                                        <button id="closeTimeModal-{{ $loop->iteration }}" type="button"
                                            class="py-2 px-4 rounded-lg font-medium  bg-gray-100 hover:bg-gray-200 transition">Close</button>
                                        <button type="submit"
                                            class="py-2 px-4 rounded-lg font-medium bg-blue-600 text-white hover:bg-blue-700 transition">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <x-set-password :link="$link" />
                </div>
            @endforeach
            @if ($links->total() > 10)
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <div class="flex flex-1 justify-between sm:hidden">
                        {{-- Mobile View: Previous Page Link --}}
                        @if ($links->onFirstPage())
                            <span
                                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $links->previousPageUrl() }}"
                                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                        @endif

                        {{-- Mobile View: Next Page Link --}}
                        @if ($links->hasMorePages())
                            <a href="{{ $links->nextPageUrl() }}"
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
                                <span class="font-medium">{{ $links->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $links->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $links->total() }}</span>
                                results
                            </p>
                        </div>

                        <div class="flex items-center space-x-2">
                            {{-- Previous Button --}}
                            @if ($links->onFirstPage())
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
                                <a href="{{ $links->previousPageUrl() }}"
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
                                @foreach (range(max(1, $links->currentPage() - 2), min($links->lastPage(), $links->currentPage() + 2)) as $page)
                                    @if ($page == $links->currentPage())
                                        <span aria-current="page"
                                            class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $links->url($page) }}"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Next Button --}}
                            @if ($links->hasMorePages())
                                <a href="{{ $links->nextPageUrl() }}"
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
                <p class="text-gray-500 mt-4 ">Tidak ada link yang ditemukan.</p>
            </div>
        @endif
    </div>
    <div id="alert-copy"
        class="bg-green-500 shadow-lg text-white px-6 py-2 absolute right-6 bottom-6 z-[99999] rounded-lg hidden">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-4">
                <i class="fa-regular fa-circle-check text-2xl"></i>
                <p class="font-medium mr-14" id="alert-message">Teks berhasil disalin!</p>
            </div>
            <i class="fa-solid fa-xmark text-xl p-2 cursor-pointer hover:text-gray-200 transition"
                id="close-alert"></i>
        </div>
    </div>
    <x-qr-code-modal id="qrCodeModal" />

    <script>
        document.getElementById('division-filter').addEventListener('change', function() {
            this.form.submit();
        });

        document.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', function(event) {
                const id = this.getAttribute('data-id'); // Ambil ID dari data atribut
                const content = document.querySelector(
                `.accordion-content[data-id="${id}"]`); // Cari konten sesuai ID

                // Tampilkan atau sembunyikan konten accordion
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden'); // Tampilkan konten accordion
                    this.style.backgroundColor =
                    'rgb(37 99 235 / var(--tw-bg-opacity))'; // Set warna tombol menjadi biru
                    this.style.color = 'white'; // Set warna teks tombol menjadi putih
                    initializeChart(id); // Inisialisasi chart saat akordion dibuka
                } else {
                    content.classList.add('hidden'); // Sembunyikan konten accordion
                    this.style.backgroundColor = ''; // Reset warna tombol
                    this.style.color = ''; // Reset warna teks tombol
                }

                // Prevent the click event from bubbling up to the document
                event.stopPropagation();
            });
        });

        // Fungsi untuk menyalin teks ke clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                tampilkanAlert("Tautan berhasil disalin!"); // Tampilkan alert saat tautan berhasil disalin

            }, function(err) {
                alert('Gagal menyalin tautan: ', err);
            });
        }

        function salinTeksKeClipboard1(text) {
            navigator.clipboard.writeText(text).then(function() {
                tampilkanAlert("Teks berhasil disalin!");
            }, function(err) {
                console.error('Gagal menyalin teks: ', err);
            });
        }


        function tampilkanAlert(message) {
            const alertElement = document.getElementById("alert-copy");
            const alertMessage = document.getElementById("alert-message");
            alertMessage.textContent = message;
            alertElement.classList.remove('hidden'); // Menampilkan alert

            // Sembunyikan alert setelah 3 detik
            setTimeout(function() {
                alertElement.classList.add('hidden');
            }, 3000);
        }

        // Tutup alert saat tombol close diklik
        document.getElementById("close-alert").addEventListener("click", function() {
            document.getElementById("alert-copy").classList.add('hidden');
        });

        // Inisialisasi Chart.js untuk setiap link
        function initializeChart(linkId) {
            const ctx = document.getElementById(`chart-${linkId}`).getContext('2d');
            const visitorsData = JSON.parse(document.getElementById('visitorsData').value);
            const uniqueVisitorsData = JSON.parse(document.getElementById('uniqueVisitorsData').value);
            const labels = JSON.parse(document.getElementById('labels').value);

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Visitors',
                            data: visitorsData[linkId] || [],
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            borderColor: 'red',
                            borderWidth: 1,
                        },
                        {
                            label: 'Unique Visitors',
                            data: uniqueVisitorsData[linkId] || [],
                            backgroundColor: 'rgba(128, 0, 128, 0.5)',
                            borderColor: 'purple',
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                usePointStyle: true,
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                            },
                        },
                        x: {
                            stacked: true,
                        },
                    },
                },
            });
        }
    </script>
</x-dashboard-layout>
