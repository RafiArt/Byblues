<x-dashboard-layout title="Dashboard">
    @role('user')
        <section class="mb-5">
            <h1 class="text-base lg:text-lg font-bold mb-3 uppercase">Quick Access</h1>
            <div class="w-full flex flex-col lg:flex-row items-center gap-3">
                <button type="button" id="quick-access-btn"
                    class="border-2 p-3 px-5 flex items-center bg-white rounded-lg justify-between w-full lg:w-[18rem] group hover:border-blue-600 transition hover:cursor-pointer">
                    <i class="fa-solid fa-link text-lg group-hover:text-blue-600 transition"></i>
                    <h2 class="font-medium group-hover:text-blue-600 transition">Short new Link</h2>
                    <i class="fa-solid fa-chevron-right text-lg group-hover:text-blue-600 transition"></i>
                </button>
                <div id="open-qrcode-btn"
                    class="border-2 p-3 px-5 flex items-center bg-white rounded-lg justify-between w-full lg:w-[18rem] group hover:border-blue-600 transition hover:cursor-pointer">
                    <i class="fa-solid fa-qrcode text-lg group-hover:text-blue-600 transition"></i>
                    <h2 class="font-medium group-hover:text-blue-600 transition">Generate QR Code</h2>
                    <i class="fa-solid fa-chevron-right text-lg group-hover:text-blue-600 transition"></i>
                </div>
            </div>
        </section>
        <section class="w-full mb-5">
            <h1 class="text-base lg:text-lg font-bold mb-3 uppercase">Analytics</h1>
            <div class="flex w-full items-center gap-3 overflow-x-auto scroll-snap-x">
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $CountLink }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <p>Total Links</p>
                    </div>
                </div>
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $Visitor }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <p>Visitors</p>
                    </div>
                </div>
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $VisitorUnique }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        <p>Unique Visitors</p>
                    </div>
                </div>
                <a href="{{ route('analytics') }}"
                    class="flex flex-col justify-center items-center gap-1 ml-2 p-3 cursor-pointer group flex-shrink-0 scroll-snap-center"
                    title="See more">
                    <div
                        class="w-12 h-12 p-2 rounded-full border-2 flex items-center justify-center bg-white group-hover:border-blue-600 group-hover:text-blue-600 transition">
                        <i class="fa-solid fa-angle-right text-xl"></i>
                    </div>
                    <p class="text-sm">More</p>
                </a>
            </div>
        </section>
        <section class="w-full">
            <h1 class="text-base lg:text-lg font-bold mb-3 uppercase">Division Analytics</h1>
            <div class="flex w-full items-center gap-3 overflow-x-auto scroll-snap-x">
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $divisionLinksCount }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <p>Total Division Links</p>
                    </div>
                </div>
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $qrcodesDivisions }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                        <p class="whitespace-nowrap">Total Division Barcode</p>
                    </div>
                </div>
            </div>
        </section>
        <x-quick-link />
        <x-quick-qrcode />
    @endrole

    @role('administrator')
        <section class="w-full mb-5">
            <h1 class="text-base lg:text-lg font-bold mb-3 uppercase">Analytics</h1>
            <div class="flex w-full items-center gap-3 overflow-x-auto scroll-snap-x">
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $CountLink }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <p>Total Links</p>
                    </div>
                </div>
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $Visitor }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <p>Visitors</p>
                    </div>
                </div>
                <div class="border p-5 bg-white rounded-lg justify-between w-[14rem] group transition flex-shrink-0 scroll-snap-center">
                    <h3 class="text-3xl font-bold mb-2">{{ $VisitorUnique }}</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        <p>Unique Visitors</p>
                    </div>
                </div>
            </div>
        </section>
    @endrole

</x-dashboard-layout>
