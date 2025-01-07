<section id="qrcode-form"
    class="w-full h-screen hidden flex items-center justify-center fixed top-0 left-0 z-[9999] bg-gray-800 bg-opacity-30">
    <div class="flex flex-col gap-3 w-full lg:w-[30rem] bg-white p-6 rounded-lg text-gray-600">
        <div class="flex items-center justify-between ">
            <h1 class="font-semibold text-lg">Generated new QR Code</h1>
            <button type="button" id="close-btn-qrcode"
                class="w-10 h-10 flex overflow-hidden items-center justify-center hover:text-blue-700">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form action="{{ route('qrcodes.store') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-2">
                <label for="link" class="font-bold">URL</label>
                <input type="text" name="link" id="link"
                    class="rounded-lg border-2 focus:outline-none focus:ring-0 focus:border-blue-600 border-gray-300 placeholder:text-gray-300 font-medium"
                    placeholder="https://yourdomain.id/very-long-links">
            </div>
            <button
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 transition text-white font-bold rounded-lg text-sm px-5 py-2.5">Generate
                it!</button>
        </form>
    </div>
</section>

@push('qrcode-scripts')
    <script>
        const qrcodeForm = document.getElementById('qrcode-form')
        const closeBtnQrCode = document.getElementById('close-btn-qrcode')
        const openQrCodeBtn = document.getElementById('open-qrcode-btn')

        openQrCodeBtn.addEventListener('click', function() {
            qrcodeForm.classList.toggle('hidden')
        })

        closeBtnQrCode.addEventListener('click', function() {
            qrcodeForm.classList.toggle('hidden')
        })
    </script>
@endpush
