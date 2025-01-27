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

        @if($nextKategori)
            <form action="{{ route('diagnosa.saveTemp') }}" method="POST" id="diagnosisForm">
        @else
            <form action="{{ route('diagnosa.store') }}" method="POST" id="diagnosisForm">
        @endif
            @csrf
            <!-- Input Tanggal - Only show on first category -->
            @if($kategoriList->search($currentKategori) === 0)
                <div class="mb-4">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal dan Waktu</label>
                    <input type="datetime-local" id="tanggal" name="tanggal" value="{{ session('diagnosa_tanggal') }}"
                        class="mt-1 block w-full max-w-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
            @else
                <input type="hidden" name="tanggal" value="{{ session('diagnosa_tanggal') }}">
            @endif

            <!-- Kategori Title -->
            <h2 class="text-xl font-bold mb-4 text-gray-800">{{ $currentKategori }}</h2>

            <!-- Tabel Gejala -->
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">No</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Gejala</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Kondisi</th>
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
                                        <div class="flex items-center justify-center gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio"
                                                       name="kondisi[{{ $item->kode }}]"
                                                       value="ya"
                                                       {{ session('diagnosa_temp.kondisi.' . $item->kode) === 'ya' ? 'checked' : '' }}
                                                       class="form-radio h-4 w-4 text-blue-600 condition-radio">
                                                <span class="ml-2 text-sm text-gray-600">Ya</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio"
                                                       name="kondisi[{{ $item->kode }}]"
                                                       value="bisa jadi"
                                                       {{ session('diagnosa_temp.kondisi.' . $item->kode) === 'bisa jadi' ? 'checked' : '' }}
                                                       class="form-radio h-4 w-4 text-yellow-600 condition-radio">
                                                <span class="ml-2 text-sm text-gray-600">Bisa&nbsp;Jadi</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio"
                                                       name="kondisi[{{ $item->kode }}]"
                                                       value="tidak"
                                                       {{ session('diagnosa_temp.kondisi.' . $item->kode) === 'tidak' ? 'checked' : '' }}
                                                       class="form-radio h-4 w-4 text-red-600 condition-radio">
                                                <span class="ml-2 text-sm text-gray-600">Tidak</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-6">
                <a href="{{route('diagnosa.index')}}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                    Back
                </a>

                <div class="flex gap-4">
                    @if($previousKategori)
                        <a href="{{ route('diagnosa.create', ['kategori' => $previousKategori]) }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                            ← Previous
                        </a>
                    @else
                        <div></div>
                    @endif
                    @if($nextKategori)
                        <button type="submit" name="next_kategori" value="{{ $nextKategori }}" id="nextButton"
                            class="bg-gray-300 text-white px-4 py-2 rounded-md cursor-not-allowed" disabled>
                            Next →
                        </button>
                    @else
                        <button type="submit" id="submitButton"
                            class="bg-gray-300 text-white px-4 py-2 rounded-md cursor-not-allowed" disabled>
                            Submit
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <script>
        // Function to check if all conditions are filled
        function checkAllConditionsFilled() {
            const radioGroups = document.querySelectorAll('input[type="radio"]');
            const groupNames = new Set();
            radioGroups.forEach(radio => groupNames.add(radio.name));

            let allChecked = true;
            groupNames.forEach(name => {
                const checked = document.querySelector(`input[name="${name}"]:checked`);
                if (!checked) {
                    allChecked = false;
                }
            });

            return allChecked;
        }

        // Function to update button state
        function updateButtonState() {
            const nextButton = document.getElementById('nextButton') || document.getElementById('submitButton');
            const isAllFilled = checkAllConditionsFilled();

            if (isAllFilled) {
                nextButton.disabled = false;
                nextButton.classList.remove('bg-gray-300', 'cursor-not-allowed');
                nextButton.classList.add('bg-teal-500', 'hover:bg-teal-600');
            } else {
                nextButton.disabled = true;
                nextButton.classList.remove('bg-teal-500', 'hover:bg-teal-600');
                nextButton.classList.add('bg-gray-300', 'cursor-not-allowed');
            }
        }

        // Add event listeners to all radio buttons
        document.querySelectorAll('.condition-radio').forEach(radio => {
            radio.addEventListener('change', updateButtonState);
        });

        // Initial check on page load
        updateButtonState();
    </script>
</x-dashboard-layout>
