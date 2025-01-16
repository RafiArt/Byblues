<div id="editGejalaModal{{ $gejala->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Edit Gejala
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="editGejalaModal{{ $gejala->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('gejala.update', $gejala->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="edit_kode{{ $gejala->id }}" class="block mb-2 text-sm font-medium text-gray-900">Kode Gejala</label>
                        <input type="text" name="kode" id="edit_kode{{ $gejala->id }}" value="{{ $gejala->kode }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>
                    <div>
                        <label for="edit_keterangan{{ $gejala->id }}" class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan{{ $gejala->id }}" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>{{ $gejala->keterangan }}</textarea>
                    </div>
                    <div>
                        <label for="edit_kategori{{ $gejala->id }}" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                        <select name="kategori" id="edit_kategori{{ $gejala->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="Kesejahteraan Emosional" {{ $gejala->kategori == 'Kesejahteraan Emosional' ? 'selected' : '' }}>Kesejahteraan Emosional</option>
                            <option value="Kesejahteraan Fisik" {{ $gejala->kategori == 'Kesejahteraan Fisik' ? 'selected' : '' }}>Kesejahteraan Fisik</option>
                            <option value="Hubungan Sosial" {{ $gejala->kategori == 'Hubungan Sosial' ? 'selected' : '' }}>Hubungan Sosial</option>
                            <option value="Peran dan Dukungan Keluarga" {{ $gejala->kategori == 'Peran dan Dukungan Keluarga' ? 'selected' : '' }}>Peran dan Dukungan Keluarga</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button data-modal-hide="editGejalaModal{{ $gejala->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
