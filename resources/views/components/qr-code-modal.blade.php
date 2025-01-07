<!-- Modal for displaying QR Code -->
<div id="qrCodeModal" class="fixed z-[999] !mt-0 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-[30rem]">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">QR Code</h2>
            <button class="text-gray-500 hover:text-gray-700" onclick="toggleModal('qrCodeModal')">
                <i class="fa-solid fa-xmark text-3xl"></i>
            </button>
        </div>

        <div id="qrCodeContent" class="mt-4 flex justify-center">
            <img src="" alt="QR Code" id="qrCodeImage" style="width: 250px; height: 250px;">
        </div>

        <div id="downloadButtonContainer" class="mt-4 flex justify-center">
            <button id="downloadButton"
                class="flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
                onclick="downloadQrCode()">
                <i class="fa fa-download"></i>
                <span>Download QR Code</span>
            </button>
        </div>

        <div class="mt-4 text-right">
            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                onclick="toggleModal('qrCodeModal')">Close</button>
        </div>
    </div>
</div>
