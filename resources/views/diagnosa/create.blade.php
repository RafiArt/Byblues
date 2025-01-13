<x-dashboard-layout title="Create Diagnosis">
    <div class="container mx-auto p-4">
        <!-- Input Tanggal -->
        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal"
                class="mt-1 block w-full max-w-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>

        <!-- Tabel Gejala -->
        <div class="overflow-x-auto">
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
                    @foreach ($gejala as $kategori => $gejalas)
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-200">
                                <strong>{{ $kategori }}</strong>
                            </td>
                        </tr>
                        @foreach ($gejalas as $item)
                            @if (
                                (auth()->user()->peran === 'Ibu' && str_starts_with($item->kode, 'IB')) ||
                                (auth()->user()->peran === 'Suami' && str_starts_with($item->kode, 'SU')) ||
                                (auth()->user()->peran === 'Orang Tua' && str_starts_with($item->kode, 'OT'))
                            )
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
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
