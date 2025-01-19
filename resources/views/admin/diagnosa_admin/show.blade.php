<x-dashboard-layout title="Diagnosis Details">
    <div class="w-full lg:w-2/3 mt-3 space-y-2 mx-auto">
        <!-- Card Wrapper -->
        <div class="w-full bg-white rounded-lg shadow-lg" id="printable">
            <!-- Header Section -->
            <div class="w-full p-4 border-b rounded-t-lg flex items-center justify-between">
                <div class="flex-1 flex items-center">
                    <h2 class="font-bold text-lg lg:text-2xl text-gray-600">Hasil Diagnosis</h2>
                </div>
            </div>

            <!-- Body Section with CF Value and Hasil -->
            <div class="p-4">
                <!-- User Info -->
                <div class="flex-1 flex items-center justify-between">
                    <h2 class="font-bold text-lg lg:text-xl text-grey-700">Data Pengguna:</h2>
                    <span class="text-sm text-gray-500">{{ date('d M Y H:i', strtotime($diagnosa->created_at)) }}</span>
                </div>

                <div  class="mt-2">
                    <h1 class="text-gray-700 font-semibold text-base flex items-start">
                        <span>Nama:</span>
                        <span class="ml-2 text-grey-600 font-semibold">{{ optional($diagnosa->user)->name ?? 'N/A' }}</span>
                    </h1>
                </div>
                <div  class="mt-2">
                    <h1 class="text-gray-700 font-semibold text-base flex items-start">
                        <span>Email:</span>
                        <span class="ml-2 text-grey-600 font-semibold">{{ optional($diagnosa->user)->email ?? 'N/A' }}</span>
                    </h1>
                </div>
                <div class="mt-2">
                    <h1 class="text-gray-700 font-semibold text-base flex items-start">
                        <span>Peran:</span>
                        <span class="ml-2 text-grey-600 font-semibold">{{ optional($diagnosa->user)->peran ?? 'N/A' }}</span>
                    </h1>
                </div>
            </div>


            <div class="w-full bg-gray-50 p-4 border-t flex items-center justify-between rounded-b-lg">
                <div class="flex-1 flex flex-col">
                    <h2 class="font-bold text-lg lg:text-xl text-grey-700">Hasil Diagnosa:</h2>
                    <h1 class="text-gray-700 font-semibold text-base flex items-start mt-2">
                       <!-- Diagnosis Result -->
                        <div class="mt-2">
                            <p class="text-gray-700 font-semibold text-base flex items-start">
                                <span>Hasil:</span>
                                <span class="ml-2">
                                    @if($diagnosa->hasil == 'Tidak Ada Risiko Baby Blues')
                                        <span class="rounded px-2 py-1 text-white font-semibold bg-green-600">
                                            {{ $diagnosa->hasil }}
                                        </span>
                                    @elseif($diagnosa->hasil == 'Risiko Rendah Baby Blues')
                                        <span class="rounded px-2 py-1 text-white font-semibold bg-blue-600">
                                            {{ $diagnosa->hasil }}
                                        </span>
                                    @elseif($diagnosa->hasil == 'Risiko Sedang Baby Blues')
                                        <span class="rounded px-2 py-1 text-white font-semibold bg-yellow-500">
                                            {{ $diagnosa->hasil }}
                                        </span>
                                    @elseif($diagnosa->hasil == 'Risiko Tinggi Baby Blues')
                                        <span class="rounded px-2 py-1 text-white font-semibold bg-red-600">
                                            {{ $diagnosa->hasil }}
                                        </span>
                                    @endif
                                </span>
                            </p>
                        </div>
                    </h1>
                    <div  class="mt-2">
                        <h1 class="text-gray-700 font-semibold text-base flex items-start">
                            <span>Skor:</span>
                            @php
                                $cf_value = $diagnosa->cf_value;
                                $skor  =  $cf_value * 20;
                            @endphp
                            <span class="ml-2 text-grey-600 font-semibold">{{ $skor }}</span>
                        </h1>
                    </div>
                    <div  class="mt-2">
                        <h1 class="text-gray-700 font-semibold text-base flex items-start">
                            <span class="text-grey-600 font-semibold">{!! $diagnosa->solusi !!}</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="w-full bg-gray-50 p-4 border-t flex items-center justify-between rounded-b-lg">
                <div class="flex-1 flex flex-col">
                    <h2 class="font-bold text-lg lg:text-xl text-grey-700">Note:</h2>
                    <h1 class="text-gray-700 font-semibold text-base flex flex-col items-start mt-2 space-y-2">
                        <span class="mt-2">Klasifikasikan ke dalam empat kategori sebagai berikut:</span>
                        <span class="flex items-center">
                            • <strong class="ml-2">Tidak ada risiko babyblues:</strong> Jika akumulasi skor berada pada rentang 0-9.
                        </span>
                        <span class="flex items-center">
                            • <strong class="ml-2">Risiko rendah babyblues:</strong> Jika akumulasi skor berada pada rentang 10-13.
                        </span>
                        <span class="flex items-center">
                            • <strong class="ml-2">Risiko sedang babyblues:</strong> Jika akumulasi skor berada pada rentang 14-19.
                        </span>
                        <span class="flex items-center">
                            • <strong class="ml-2">Risiko tinggi babyblues:</strong> Jika akumulasi skor berada pada rentang 20 atau lebih.
                        </span>
                    </h1>
                </div>
            </div>

            <!-- Additional Content -->
            <div class="w-full bg-gray-50 p-4 border-t flex items-center justify-between rounded-b-lg">
                <div class="flex-1 flex flex-col">
                    <h2 class="font-bold text-lg lg:text-xl text-grey-700">Saran:</h2>
                    <h1 class="text-gray-700 font-semibold text-base flex flex-col items-start mt-2 space-y-2">
                        <span class="mt-2">Hubungi pihak kesehatan seperti psikiater atau psikolog jika memang sudah terlalu parah.</span>
                    </h1>

                    <!-- Buttons Section -->
                    <div class="mt-4 space-x-2 flex justify-start no-print">
                        <!-- Print Button -->
                        <button onclick="window.print()" class="flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                            <i class="fa-solid fa-print"></i>
                            Print
                        </button>
                        <!-- Back Button -->
                        <a href="{{route('diagnosa_admin.index')}}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print CSS -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printable, #printable * {
                visibility: visible;
            }
            #printable {
                position: absolute;
                top: 0;
                left: 0;
                box-shadow: none; /* Menambahkan aturan untuk menghapus shadow */
            }
            .no-print {
                display: none !important;
            }
        }

    </style>
</x-dashboard-layout>
