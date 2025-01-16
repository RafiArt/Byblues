<!-- Modal Tambah Gejala -->
<div id="addGejalaModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden w-full h-full bg-gray-800 bg-opacity-50 backdrop-blur-sm flex justify-center items-center">
    <div class="relative w-full max-w-md max-h-full bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 border-b rounded-t">
            <h3 class="text-xl font-semibold text-gray-900">Tambah Gejala Baru</h3>
            <button type="button" data-modal-hide="addGejalaModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('gejala.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-4">
                @error('kode')
                    <p class="text-red-600 text-sm">*{{ $message }}</p>
                @enderror
                <div>
                    <label for="kode" class="block mb-2 text-sm font-medium text-gray-900">Kode Gejala</label>
                    <input type="text" name="kode" id="kode"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required value="" placeholder="Isi Kode...">

                </div>
                <div>
                    <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required placeholder="Isi Keterangan berupa pertanyaan..."></textarea>
                </div>
                <div>
                    <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                    <select name="kategori" id="kategori"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required>
                        <option value="">Pilih Kategori</option>
                        <option value="Kesejahteraan Emosional">Kesejahteraan Emosional</option>
                        <option value="Kesejahteraan Fisik">Kesejahteraan Fisik</option>
                        <option value="Hubungan Sosial">Hubungan Sosial</option>
                        <option value="Peran dan Dukungan Keluarga">Peran dan Dukungan Keluarga</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                <button data-modal-hide="addGejalaModal" type="button"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" id="cancelBtn">
                    Batal
                </button>


                <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Mendapatkan elemen modal dan tombol
    const modal = document.getElementById("addGejalaModal");
    const btnOpenModal = document.querySelector('[data-modal-toggle="addGejalaModal"]');
    const btnCloseModal = modal.querySelector('[data-modal-hide="addGejalaModal"]');
    const cancelBtn = document.getElementById("cancelBtn"); // Menambahkan id untuk tombol batal
    const form = modal.querySelector('form'); // Mengambil form di dalam modal

    // Menampilkan modal saat tombol ditekan
    btnOpenModal.addEventListener('click', function() {
        modal.classList.remove('hidden');
    });

    // Menutup modal saat tombol close ditekan atau tombol batal ditekan
    btnCloseModal.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    function closeModal() {
        modal.classList.add('hidden'); // Menutup modal
        form.reset(); // Menghapus isi dari semua input dan textarea di dalam form
    }
</script>


