<x-dashboard-layout title="Analytics">

    <div class="bg-gray-100 pb-20 lg:pb-0">
        <div class="container mx-auto lg:p-4 mb-4">
            <div class="bg-white rounded-lg shadow p-4 pb-0 lg:pb-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Timeline</h2>
                    <form method="GET" action="{{ route('analytics') }}" class="flex items-center gap-2">
                        <label for="tahun">Pilih Tahun:</label>
                        <select name="tahun" id="tahun" onchange="this.form.submit()" class="rounded text-sm">
                            {{-- <option value="">Pilih Tahun</option> --}}
                            @for ($i = date('Y'); $i > date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ $i == $selectedYear ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
                <div class="border-b-2 rounded h-64 flex items-center justify-start overflow-x-auto w-full">
                    <div class="text-center min-w-[1150px]">
                        <canvas id="myChart" width="1150" height="250"></canvas>
                    </div>
                </div>
                <div class="mt-4 flex overflow-x-auto w-full pb-4">
                    <!-- First item -->
                    <div class="flex-shrink-0 flex flex-col items-center min-w-[150px]">
                        <p class="text-2xl font-semibold">{{ $linksCount }}</p>
                        <p class="text-sm text-gray-500 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                            Total Links
                        </p>
                    </div>
                    <!-- Second item -->
                    <div class="flex-shrink-0 flex flex-col items-center min-w-[150px] border-l border-gray-300">
                        <p class="text-2xl font-semibold">{{ $linksVisitors }}</p>
                        <p class="text-sm text-gray-500 flex items-center">
                            <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                            Visitors
                        </p>
                    </div>
                    <!-- Third item -->
                    <div class="flex-shrink-0 flex flex-col items-center min-w-[150px] border-l border-gray-300">
                        <p class="text-2xl font-semibold">{{ $uniqueVisitors }}</p>
                        <p class="text-sm text-gray-500 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-1"></span>
                            Unique Visitor
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="container mx-auto lg:p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Popular Links Section -->
            <div class="bg-white p-6 rounded-lg shadow w-full h-[500px] flex flex-col">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-link mr-2"></i> Popular Links
                </h2>
                <div class="space-y-4">
                    @if ($link->isNotEmpty())
                        @foreach ($link as $index => $links)
                            <div class="flex justify-between items-center border-b pb-4">
                                <div class="flex items-center ">
                                    <p class="text-sm font-medium text-gray-300 mr-2">{{ sprintf('%02d', $index + 1) }}.
                                    </p>
                                    <div class="w-[220px] md:w-full overflow-hidden">
                                        <p class="text-sm font-medium">
                                            <a href="{{ $links->short_url }}" class="text-blue-600">
                                                {{ $links->short_url }}
                                            </a>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            @if (strlen($links->original_url) > 65)
                                                {{ substr($links->original_url, 0, 65) }}...
                                            @else
                                                {{ $links->original_url }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-900">{{ $links->clicks }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center h-64">
                            <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                            <p class="text-center">Empty Data</p>
                            <p class="text-sm text-gray-500 text-center">No data available</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow w-full h-[500px]">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-qrcode mr-2"></i> Latest QR Code
                </h2>
                <div class="space-y-4">
                    @if ($qrcodes->isNotEmpty())
                        @foreach ($qrcodes as $index => $qrcode)
                            <div class="flex justify-between items-center border-b pb-4">
                                <div class="flex items-center">
                                    <p class="text-sm font-medium text-gray-300 mr-2">
                                        {{ sprintf('%02d', $index + 1) }}.
                                    </p>
                                    <div class="w-[220px] md:w-full overflow-hidden">
                                        <p class="text-sm font-medium">
                                            <a href="{{ $qrcode->link }}" class="text-blue-600">
                                                <p class="text-xs text-gray-500">
                                                    @if (strlen($qrcode->link) > 65)
                                                        {{ substr($qrcode->link, 0, 65) }}...
                                                    @else
                                                        {{ $qrcode->link }}
                                                    @endif
                                                </p>
                                            </a>
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $qrcode->created_at }}</p>
                                    </div>
                                </div>
                                <a href="/qrcodes"
                                    class="flex items-center justify-center w-10 p-3 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm">
                                    <i class="fa-solid fa-qrcode"></i>
                                </a>
                                {{-- <button id="openModal"
                                    class="flex items-center justify-center w-9 h-9 lg:w-10 lg:h-10 bg-gray-300 rounded hover:bg-blue-600 hover:text-white transition text-gray-700 text-xs lg:text-sm"
                                    data-id="{{ $qrcode->id }}"
                                    data-link="{{ $qrcode->link }}"
                                    data-qrcode="{{ base64_encode($qrcode->qrcode) }}"
                                    onclick="openQrCodeModal(this)">
                                    <i class="fa-solid fa-qrcode"></i>
                                </button> --}}
                            </div>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center h-64">
                            <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                            <p class="text-center">Empty Data</p>
                            <p class="text-sm text-gray-500 text-center">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates), // Menggunakan tanggal dari controller
                datasets: [{
                    label: 'Upload Links Per Day',
                    data: @json($counts), // Menggunakan jumlah tautan dari controller
                    borderWidth: 2, // Lebar garis
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                    fill: false,
                    tension: 0.4, // Mengatur kelenturan garis (0 = garis lurus, 1 = lengkung penuh)
                    spanGaps: true // Mengabaikan titik kosong untuk membuat garis lebih halus
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        },
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-dashboard-layout>
