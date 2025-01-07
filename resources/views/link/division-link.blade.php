<x-dashboard-layout title="Division Link">
    <div class="w-full mt-6 space-y-2">
        <div class="w-full mt-6 flex flex-col lg:flex-row gap-2 lg:gap-0 lg:items-center justify-between">
            <h1 class="font-bold">Latest Generated Links Division</h1>
            <form action="{{ route('links.divisionLink') }}" method="GET" class="relative">
                <input type="text" class="w-full lg:w-[20rem] rounded border-gray-200 text-sm" id="search"
                    name="search" placeholder="Search">
                <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-gray-300"></i>
            </form>
        </div>
        <div class="w-full mt-6 space-y-2">
            @if ($divisionLinks->isEmpty())
                <div class="bg-gray-100 p-8 text-center">
                    <div class="bg-transparent mx-auto w-full max-w-xs rounded overflow-hidden">
                        <video autoplay loop muted playsinline class="w-full" style="background-color: transparent;">
                            <source src="{{ asset('video/vid2-rm.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                    </div>
                    <p class="text-gray-500 mt-4 text-xl">Tidak ada link division yang ditemukan.</p>
                </div>
            @else
                @foreach ($divisionLinks as $divisi)
                    <div class="w-full bg-white rounded-lg relative mb-4">
                        <div class="w-full p-4 border rounded-t-lg lg:flex items-start justify-between">
                            <div class="w-full overflow-hidden">
                                <h1 class="font-semibold mb-3 text-lg">{{ $divisi->title }}</h1>
                                <h3 onclick="salinTeksKeClipboard('{{ env('APP_URL') . '/' . $divisi->short_url }}')"
                                    class="text-lg lg:text-2xl font-semibold hover:decoration-black hover:underline hover:cursor-pointer text-blue-600">
                                    {{ ENV('APP_NAME') }}<span
                                        class="text-black hover:cursor-pointer">{{env('APP_DOMAIN')}}/{{ $divisi->short_url }}</span>
                                </h3>
                                <p class="text-xs lg:text-sm text-gray-400 hover:underline hover:cursor-pointer">
                                    {{ $divisi->original_url }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 mt-2 lg:mt-0">
                                <div class="relative dropdown-container">
                                    <button class="flex items-center gap-2 p-2 px-3 bg-blue-600 rounded hover:bg-blue-800 transition text-white text-xs lg:text-sm"
                                        onclick="toggleDropdown(this)">
                                        <i class="fa-solid fa-share-nodes"></i>
                                        <p class="hidden lg:block">Share</p>
                                    </button>
                                    <div class="absolute hidden top-15 w-40 bg-white border rounded shadow-lg z-10 dropdown"
                                        style="margin-top: 0;">
                                        <ul>
                                            <li class="flex flex-col items-start px-1 py-1">
                                                <div class="w-full hover:bg-gray-200 mb-2">
                                                    <a href="https://twitter.com/share?url={{ env('APP_URL') . '/' . $divisi->short_url }}"
                                                        target="_blank" class="flex items-center px-2 py-1 w-full">
                                                        <i class="fab fa-twitter-square text-blue-500 fa-lg"></i>
                                                        <span class="ml-2">Twitter</span>
                                                    </a>
                                                </div>
                                                <div class="w-full hover:bg-gray-200 mb-2">
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ env('APP_URL') . '/' . $divisi->short_url }}"
                                                        target="_blank" class="flex items-center px-2 py-1 w-full">
                                                        <i class="fab fa-facebook-square text-blue-500 fa-lg"></i>
                                                        <span class="ml-2">Facebook</span>
                                                    </a>
                                                </div>
                                                <div class="w-full hover:bg-gray-200 mb-2">
                                                    <a href="whatsapp://send?text={{ env('APP_URL') . '/' . $divisi->short_url }}"
                                                        target="_blank" class="flex items-center px-2 py-1 w-full">
                                                        <i class="fab fa-whatsapp-square text-green-500 fa-lg"></i>
                                                        <span class="ml-2">WhatsApp</span>
                                                    </a>
                                                </div>
                                                <div class="w-full hover:bg-gray-200">
                                                    <a href="#" onclick="copyToClipboard('{{ env('APP_URL') . '/' . $divisi->short_url }}'); return false;"
                                                        class="flex items-center px-2 py-1 w-full">
                                                        <i class="fas fa-copy text-gray-500 fa-lg"></i>
                                                        <span class="ml-2">Copy</span>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @foreach ($divisi->qrcodes as $qrcode)
                                    <button id="openModal"
                                        class="flex items-center justify-center gap-2 p-2 px-3 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm"
                                        data-id="{{ $qrcode->id }}" data-link="{{ $qrcode->link }}"
                                        data-qrcode="{{ base64_encode($qrcode->qrcode) }}"
                                        onclick="openQrCodeModal(this)">
                                        <i class="fa-solid fa-qrcode"></i>
                                        <p class="hidden lg:block">QR</p>
                                    </button>

                                @endforeach
                            </div>
                        </div>
                        <div
                            class="w-full bg-white p-4 border rounded-b-lg border-t-0 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-400 font-semibold">
                                <i class="fa-regular fa-calendar text-lg"></i>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-normal text-gray-500">
                                        {{ date('d M Y H:i', strtotime($divisi->created_at)) }}
                                        <!-- Tanggal pembuatan -->
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-user text-lg"></i> <!-- Ikon untuk menunjukkan pembuat -->
                                    <p class="text-sm font-normal text-gray-500">
                                        {{ $divisi->user->name }} <!-- Menampilkan nama pembuat -->
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                @if ($divisi->expiration_date && $divisi->expiration_date > now())
                                    <button disabled id="set-time-btn-{{ $divisi->id }}" title="Time-based Link"
                                        class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-green-100 rounded hover:bg-green-200 transition text-green-600 text-xs lg:text-sm hidden lg:block mr-4">
                                        <div class="flex items-center justify-between w-full">
                                            <i class="fa-solid fa-clock"></i>
                                            <p class="ml-1 mb-0"> <!-- Ubah margin untuk mengurangi jarak -->
                                                {{ date('d F Y, H:i', strtotime($divisi->expiration_date)) }}
                                            </p>
                                        </div>
                                    </button>
                                @elseif ($divisi->expiration_date && $divisi->expiration_date < now())
                                    <button disabled id="set-time-btn-{{ $divisi->id }}" title="Time-based Link"
                                        class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-red-200 rounded hover:bg-blue-600 hover:text-white transition text-red-700 text-xs lg:text-sm hidden lg:block mr-4">
                                        <div class="flex items-center justify-between w-full">
                                            <i class="fa-solid fa-clock"></i>
                                            <p class="ml-1 mb-0">Expired</p> <!-- Ubah margin untuk mengurangi jarak -->
                                        </div>
                                    </button>
                                @else
                                    <button disabled id="set-time-btn-{{ $divisi->id }}" title="Time-based Link"
                                        class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-gray-300 rounded transition text-gray-700 text-xs lg:text-sm hidden lg:block mr-4">
                                        <div class="flex items-center justify-between w-full">
                                            <i class="fa-solid fa-clock"></i>
                                            <p class="ml-1 mb-0">Time not set</p>
                                            <!-- Ubah margin untuk mengurangi jarak -->
                                        </div>
                                    </button>
                                @endif
                                @if ($divisi->password)
                                    <button disabled id="pashphraseBtn-{{ $divisi->id }}" title="Protected Link"
                                        class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-blue-100 rounded hover:bg-blue-200 text-blue-600 transition text-xs lg:text-sm hidden lg:block">
                                        <div class="flex items-center justify-between w-full">
                                            <i class="fa-solid fa-lock"></i>
                                            <p class="ml-1 mb-0">Locked</p> <!-- Ubah margin untuk mengurangi jarak -->
                                        </div>
                                    </button>
                                @else
                                    <button disabled id="pashphraseBtn-{{ $divisi->id }}" title="Protected Link"
                                        class="flex items-center justify-center p-2 w-10 lg:w-auto lg:px-3 bg-gray-300 rounded transition text-gray-700 text-xs lg:text-sm hidden lg:block">
                                        <div class="flex items-center justify-between w-full">
                                            <i class="fa-solid fa-lock-open"></i>
                                            <p class="ml-1 mb-0">No Password</p>
                                            <!-- Ubah margin untuk mengurangi jarak -->
                                        </div>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                @endforeach
                @if ($divisionLinks->total() > 10)
                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                        <div class="flex flex-1 justify-between sm:hidden">
                            {{-- Mobile View: Previous Page Link --}}
                            @if ($divisionLinks->onFirstPage())
                                <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                            @else
                                <a href="{{ $divisionLinks->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                            @endif

                            {{-- Mobile View: Next Page Link --}}
                            @if ($divisionLinks->hasMorePages())
                                <a href="{{ $divisionLinks->nextPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                            @else
                                <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Next</span>
                            @endif
                        </div>

                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $divisionLinks->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $divisionLinks->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $divisionLinks->total() }}</span>
                                    results
                                </p>
                            </div>

                            <div class="flex items-center space-x-2">
                                {{-- Previous Button --}}
                                @if ($divisionLinks->onFirstPage())
                                    <span class="cursor-not-allowed opacity-50">
                                        <button type="button" disabled class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 cursor-not-allowed">
                                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Previous
                                        </button>
                                    </span>
                                @else
                                    <a href="{{ $divisionLinks->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Previous
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                <div class="flex space-x-1">
                                    @foreach(range(
                                        max(1, $divisionLinks->currentPage() - 2),
                                        min($divisionLinks->lastPage(), $divisionLinks->currentPage() + 2)
                                    ) as $page)
                                        @if ($page == $divisionLinks->currentPage())
                                            <span aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $divisionLinks->url($page) }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Next Button --}}
                                @if ($divisionLinks->hasMorePages())
                                    <a href="{{ $divisionLinks->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
    </div>
    <x-qr-code-modal id="qrCodeModal" />
    <script>
        function toggleDropdown(button) {
            // Cari dropdown yang terkait dengan tombol yang diklik
            const dropdown = button.nextElementSibling;

            // Sembunyikan semua dropdown lainnya
            document.querySelectorAll('.dropdown').forEach(d => {
                if (d !== dropdown) {
                    d.classList.add('hidden');
                }
            });

            // Toggle visibilitas dropdown yang terkait
            dropdown.classList.toggle('hidden');
        }

        // Menambahkan event listener untuk menutup dropdown jika klik di luar dropdown
        document.addEventListener('click', function (event) {
            const dropdowns = document.querySelectorAll('.dropdown');
            const dropdownContainers = document.querySelectorAll('.dropdown-container');

            dropdowns.forEach(dropdown => {
                // Cek jika klik di luar dropdown
                if (!dropdown.contains(event.target) && !dropdown.closest('.dropdown-container').contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });


        // Fungsi untuk menyalin teks ke clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                tampilkanAlert("Tautan berhasil disalin!");
            }, function(err) {
                alert('Gagal menyalin tautan: ', err);
            });
        }

        // Fungsi untuk menyalin teks ke clipboard (dengan notifikasi)
        function salinTeksKeClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                tampilkanAlert("Teks berhasil disalin!");
            }, function(err) {
                console.error('Gagal menyalin teks: ', err);
            });
        }

        // Menampilkan alert dengan pesan
        function tampilkanAlert(message) {
            const alertElement = document.getElementById("alert-copy");
            const alertMessage = document.getElementById("alert-message");
            alertMessage.textContent = message;
            alertElement.classList.remove('hidden');

            // Sembunyikan alert setelah 3 detik
            setTimeout(function() {
                alertElement.classList.add('hidden');
            }, 3000);
        }

        // Menutup alert ketika tombol X diklik
        document.getElementById("close-alert").addEventListener("click", function() {
            document.getElementById("alert-copy").classList.add('hidden');
        });
    </script>

</x-dashboard-layout>
