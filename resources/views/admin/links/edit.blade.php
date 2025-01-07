<x-dashboard-layout title="Edit Link Admin">
    <form action="{{ route('links_admin.update', $link->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-4 max-w-xl">
            <div class="flex flex-col gap-2">
                <label for="" class="font-semibold lg:text-lg">Title</label>
                @error('link_title')
                    <p class="text-red-600 text-sm">*{{ $message }}</p>
                @enderror
                <div class="relative">
                    <input type="text" name="link_title" placeholder="My Link"
                        value="{{ old('link_title', $link->title) }}"
                        class="w-full rounded-lg border bg-white font-medium placeholder:text-gray-400 px-4 py-3">
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <label for="deskripsi" class="font-semibold lg:text-lg">Deskripsi</label>
                @error('deskripsi')
                    <p class="text-red-600 text-sm">*{{ $message }}</p>
                @enderror
                <div class="relative">
                    <textarea name="deskripsi" placeholder="Deskripsi"
                        class="w-full rounded-lg border bg-white font-medium placeholder:text-gray-400 px-4 py-3">{{ old('deskripsi', $link->deskripsi) }}</textarea>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="" class="font-semibold lg:text-lg">Short URL</label>
                @error('short_url')
                    <p class="text-red-600 text-sm">*{{ $message }}</p>
                @enderror
                <div class="relative">
                    <!-- Elemen teks "SIERLink/" -->
                    <p
                        class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold flex items-center whitespace-nowrap pr-2">
                        <span class="text-blue-600">{{ ENV('APP_NAME') }}</span>{{env('APP_DOMAIN')}}/
                    </p>
                    <!-- Input field -->
                    <input type="text" name="short_url" value="{{ old('short_url', $link->short_url) }}"
                        class="w-full pl-[6rem] md:pl-[6rem] rounded-lg border bg-white font-medium placeholder:text-gray-400 py-3">
                </div>
                <div class="flex items-center gap-2 text-xs lg:text-sm">
                    <i class="fa-solid fa-circle-info"></i>
                    <p>Changing links also change QR code information.</p>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="font-semibold lg:text-lg">Original URL</label>
                <div class="relative">
                    <input type="text" name="original_url" placeholder="My Link"
                        value="{{ old('original_url', $link->original_url) }}"
                        class="w-full rounded-lg border bg-white font-medium placeholder:text-gray-400 px-4 py-3 text-gray-500"
                        disabled>
                </div>
            </div>
            <div class="flex items-center justify-between mt-6">
                <button id="btn-modal-delete" type="button"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 ">
                    Delete
                </button>
                <div class="flex items-center gap-2 ">
                    <a href="{{ route('links_admin.index') }}" type="button"
                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</a>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">Save</button>

                </div>
            </div>
        </div>
    </form>

    <div id="modal"
        class="fixed top-0 hidden items-center justify-center right-0 w-full h-screen bg-gray-900 bg-opacity-80 z-[99999]">
        <div class="bg-white w-[30rem] p-6 rounded-lg opacity-100 flex items-center justify-center flex-col gap-5">
            <i class="fa-solid fa-circle-exclamation text-5xl text-red-500"></i>
            <p>Are yout sure you want to <span class="font-bold">delete</span> this link?</p>
            <div class="flex items-center gap-6">
                <button id="cancel-btn" type="button"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>
                <form action="{{ route('links_admin.destroy', $link->id) }}" method="POST">
                    @csrf
                    @method('DELETE') <!-- Pastikan menggunakan huruf kapital untuk DELETE -->
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Delete</button>
                </form>

            </div>
        </div>

    </div>

    @push('scripts')
        <script type="text/javascript">
            const modal = document.getElementById('modal');
            const btnModal = document.getElementById('btn-modal-delete');
            const cancelBtn = document.getElementById('cancel-btn');

            console.log(modal);

            btnModal.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            })
            cancelBtn.addEventListener('click', () => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            })
        </script>
    @endpush
</x-dashboard-layout>
