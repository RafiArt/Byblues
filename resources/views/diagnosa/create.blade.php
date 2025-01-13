<x-dashboard-layout title="Create Diagnosis">
    <div class="container mx-auto p-4">
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-700">Progress</span>
                <span class="text-sm font-medium text-gray-700">
                    {{ $kategoriList->search($currentKategori) + 1 }} dari {{ $kategoriList->count() }}
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full"
                     style="width: {{ (($kategoriList->search($currentKategori) + 1) / $kategoriList->count()) * 100 }}%">
                </div>
            </div>
        </div>

        <form action="{{ route('diagnosa.store') }}" method="POST">
            @csrf
            <!-- Input Tanggal - Only show on first category -->
            @if($kategoriList->search($currentKategori) === 0)
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal"
                    class="mt-1 block w-full max-w-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            @endif

            <!-- Kategori Title -->
            <h2 class="text-xl font-bold mb-4 text-gray-800">{{ $currentKategori }}</h2>

            <!-- Tabel Gejala -->
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">No</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Gejala</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Kondisi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $no = 1; @endphp
                        @foreach ($gejala as $items)
                            @foreach ($items as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $no++ }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $item->keterangan }}</td>
                                    <td class="px-4 py-2">
                                        <select name="kondisi[{{ $item->kode }}]"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                            <option value="">Pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="bisa jadi">Bisa Jadi</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-6">
                @if($previousKategori)
                    <a href="{{ route('diagnosa.create', ['kategori' => $previousKategori]) }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        ← Previous
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextKategori)
                    <a href="{{ route('diagnosa.create', ['kategori' => $nextKategori]) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                        Next →
                    </a>
                @else
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                        Submit
                    </button>
                @endif
            </div>
        </form>
    </div>
</x-dashboard-layout>
