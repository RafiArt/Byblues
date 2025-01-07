@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}.id</title>
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.7.1-web/css/all.min.css') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}">




    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="{{ asset('chart.js-4.4.7/package/dist/chart.umd.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dashboard/link.js', 'resources/js/dashboard/qrcode.js', 'resources/js/dashboard/share.js'])

    <style>
        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            /* This will allow the sidebar to scroll when its content exceeds the viewport height */
        }

        /* Ensure the body takes full height and flexbox behavior applies properly */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
        }

        /* Adjust the main content container to allow scrolling */
        main {
            height: calc(100vh - 70px);
            /* Adjust height based on any header/nav-bar height */
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Sidebar with sticky behavior -->
    <x-sidebar class="sidebar" />

    <!-- Main Content -->
    <div class="w-full relative flex flex-col">
        @include('layouts.nav-dashboard', ['title' => $title])

        <!-- Ensure main content scrolls if it exceeds the viewport -->
        <main class="w-full p-4 pb-24 lg:pb-4">
            {{ $slot }}
        </main>
    </div>
    @if (session('error'))
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

                setTimeout(function() {
                    document.getElementById('alert-error').style.display = 'none';
                }, 4000);

                document.getElementById('close-error-alert').addEventListener('click', function() {
                    document.getElementById('alert-error').style.display = 'none';
                });
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

                setTimeout(function() {
                    document.getElementById('alert-success').style.display = 'none';
                }, 4000);

                document.getElementById('close-success-alert').addEventListener('click', function() {
                    document.getElementById('alert-success').style.display = 'none';
                });
            });
        </script>
    @endif

    @include('layouts.bottom-nav')

    @stack('scripts')
    @stack('quick-link-scripts')
    @stack('qrcode-scripts')
    <script>
        function openQrCodeModal(button) {
            const qrCodeData = button.getAttribute('data-qrcode');
            const qrCodeImage = document.getElementById('qrCodeImage');
            const downloadButton = document.getElementById('downloadButton');

            qrCodeImage.src = `data:image/svg+xml;base64,${qrCodeData}`;
            downloadButton.href = `data:image/svg+xml;base64,${qrCodeData}`;

            document.getElementById('qrCodeModal').classList.remove('hidden');
        }

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }



        function downloadQrCode() {
            const svg = document.getElementById('qrCodeImage').src; // Ambil data QR Code
            const img = new Image();
            img.src = svg;

            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Atur ukuran canvas
                canvas.width = img.width;
                canvas.height = img.height;

                // Gambar SVG ke canvas
                ctx.drawImage(img, 0, 0);

                // Mengonversi canvas ke PNG
                const png = canvas.toDataURL('image/png');

                // Membuat elemen <a> untuk mengunduh gambar
                const link = document.createElement('a');
                link.href = png;
                link.download = 'qr_code.png'; // Nama file yang akan diunduh
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
        }

        function downloadbuttonQrCode(svgData) {
            const img = new Image();
            img.src = svgData;

            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Atur ukuran canvas
                canvas.width = img.width;
                canvas.height = img.height;

                // Gambar SVG ke canvas
                ctx.drawImage(img, 0, 0);

                // Mengonversi canvas ke PNG
                const png = canvas.toDataURL('image/png');

                // Membuat elemen <a> untuk mengunduh gambar
                const link = document.createElement('a');
                link.href = png;
                link.download = 'qr_code.png'; // Nama file yang akan diunduh
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };

            // Tambahkan penanganan jika gambar tidak dapat dimuat
            img.onerror = function() {
                console.error("Gambar tidak dapat dimuat.");
            };
        }

        const sidebarToggle = document.getElementById("toggleSidebar");
        const sidebarItems = document.getElementById("sidebar-items");
        const logoText = document.getElementById("logo-text");
        const sidebar = document.getElementById("sidebar-wrapper");
        const sidebarTitle = document.querySelectorAll(".sidebar-title");
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle("w-[18rem]");
            sidebar.classList.toggle("w-[5rem]");
            logoText.classList.toggle("hidden");
            sidebarItems.classList.toggle("items-center");
            sidebarTitle.forEach((title) => {
                title.classList.toggle("hidden");
            })
        })

        function toggleSubmenu(submenuId, chevronId) {
            const submenu = document.getElementById(submenuId);
            const chevron = document.getElementById(chevronId);
            const sidebar2 = document.getElementById('sidebar-wrapper');
            submenu.classList.toggle('hidden');
            chevron.classList.toggle('fa-chevron-up');
            chevron.classList.toggle('fa-chevron-down');

            sidebar.classList.add("w-[18rem]");
            sidebar.classList.remove("w-[5rem]");
            logoText.classList.remove("hidden");
            sidebarItems.classList.remove("items-center");

            sidebarTitle.forEach((title) => {
                title.classList.remove("hidden");
            })
        }
    </script>
    <script src="{{ asset('chart.js-4.4.7/package/dist/chart.umd.js') }}"></script>
</body>

</html>
