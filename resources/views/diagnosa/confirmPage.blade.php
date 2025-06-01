<x-dashboard-layout title="Persiapan Diagnosis">
    <div class="container mx-auto p-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Persiapan Diagnosis Baby Blues</h1>
                <div class="w-20 h-1 bg-blue-500 mx-auto"></div>
            </div>

            <div class="prose max-w-none mb-8">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 pt-1">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Penting!</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Diagnosis ini membutuhkan waktu sekitar 10-15 menit. Pastikan Anda memiliki waktu yang cukup untuk menyelesaikan seluruh kuisioner.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="font-semibold text-lg text-gray-800 mb-2">Petunjuk Pengisian:</h3>
                <ol class="list-decimal pl-5 space-y-2 mb-6">
                    <li>Anda akan melalui beberapa kategori pertanyaan</li>
                    <li>Setiap kategori harus diisi seluruhnya sebelum melanjutkan</li>
                    <li>Pilih salah satu dari tiga opsi kondisi untuk setiap gejala:
                        <ul class="list-disc pl-5 mt-2">
                            <li><span class="font-medium">Ya</span> - Jika gejala tersebut benar-benar Anda alami</li>
                            <li><span class="font-medium">Bisa Jadi</span> - Jika gejala tersebut mungkin Anda alami</li>
                            <li><span class="font-medium">Tidak</span> - Jika gejala tersebut tidak Anda alami</li>
                        </ul>
                    </li>
                    <li>Anda tidak dapat kembali ke halaman sebelumnya setelah melanjutkan</li>
                    <li>Hasil diagnosis akan muncul setelah semua kategori selesai diisi</li>
                </ol>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Hasil diagnosis ini bersifat prediktif berdasarkan gejala yang Anda laporkan. Untuk diagnosis medis yang akurat, harap konsultasikan dengan tenaga kesehatan profesional.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('diagnosa.start') }}" method="POST">
                    @csrf
                    <div class="flex items-start mb-6">
                        <div class="flex items-center h-5">
                            <input id="agree" name="agree" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="agree" class="font-medium text-gray-700">Saya memahami petunjuk di atas dan bersedia mengisi seluruh kuisioner dengan jujur</label>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <a href="{{ route('diagnosa.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition-colors duration-200">
                            Kembali
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors duration-200">
                            Mulai Diagnosis →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
