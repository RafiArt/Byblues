<div id="quick-link-form"
    class="hidden flex items-center justify-center bg-gray-600 fixed top-0 left-0 w-full h-screen z-[99999] bg-opacity-40">
    <form action="#" method="POST" class="w-full flex flex-col items-center justify-center ">
        @csrf
        <div class="flex flex-col gap-3 w-full lg:w-[30rem] bg-white p-6 pb-2 rounded-t-lg  text-gray-600">
            <div class="flex items-center justify-between ">
                <h1 class="font-semibold text-lg">Create New Shortened Link</h1>
                <button type="button" id="close-btn"
                    class="w-10 h-10 flex overflow-hidden items-center justify-center hover:text-blue-700">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col gap-2">
                <label for="long_url" class="font-bold">Long URL</label>
                <input type="text" name="original_url" id="long_url"
                    class="rounded-lg border-2 focus:outline-none focus:ring-0 focus:border-blue-600 border-gray-300 placeholder:text-gray-300 font-medium"
                    placeholder="https://yourdomain.id/very-long-links">
            </div>
            <div class="flex flex-col gap-2">
                <label for="title" class="font-bold">Title (optional)</label>
                <input type="text" name="title" id="title"
                    class="rounded-lg border-2 focus:outline-none focus:ring-0 focus:border-blue-600 border-gray-300 placeholder:text-gray-300 font-medium"
                    placeholder="Title">
            </div>
            <div class="flex flex-col gap-2">
                <label for="deskripsi" class="font-bold">Deskripsi (optional)</label>
                <input type="text" name="deskripsi" id="deskripsi"
                    class="rounded-lg border-2 focus:outline-none focus:ring-0 focus:border-blue-600 border-gray-300 placeholder:text-gray-300 font-medium"
                    placeholder="Deskripsi">
            </div>
            <h2 class="font-bold">Additional Settings</h2>
        </div>
        <div class="flex flex-col gap-1 w-full lg:w-[30rem] bg-gray-300 p-4   text-gray-600">
            <div class="pt-0  bg-white text-sm rounded-lg">
                <div class="p-4 py-2 rounded-lg flex items-center justify-between hover:bg-gray-100 transition cursor-pointer"
                    id="password-btn">
                    <div class="flex items-center justify-center gap-3">
                        <i class="fa-solid fa-lock">
                        </i>
                        <p class="font-semibold">Protected Link</p>
                    </div>
                    <i class="fa-solid fa-angle-down text-lg"></i>
                </div>
                <div class="hidden p-4 pt-2" id="password-accor">
                    <div class="flex items-start p-2 border bg-gray-100 my-3 gap-3">
                        <i class="fa-solid fa-circle-info mt-1"></i>
                        <p class="text-xs">A protected link can be given a secret key/passphrase for access before
                            being
                            redirected to
                            the original link</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password" class="font-bold">Password</label>
                        <input type="text" name="password" id="password"
                            class="rounded-lg w-full border-2 focus:outline-none focus:ring-0 focus:border-blue-600 border-gray-300 placeholder:text-gray-300 font-medium"
                            placeholder="_________">
                    </div>
                </div>
            </div>
            <div class="pt-0  bg-white text-sm rounded-lg">
                <div class="p-4 py-2 rounded-lg flex items-center justify-between hover:bg-gray-100 transition cursor-pointer"
                    id="expired-btn">
                    <div class="flex items-center justify-center gap-3">
                        <i class="fa-solid fa-clock"></i>
                        <p class="font-semibold">Time-based Link</p>
                    </div>
                    <i class="fa-solid fa-angle-down text-lg"></i>
                </div>
                <div class="hidden p-4 pt-2" id="expired-accor">
                    <div class="flex items-start p-2 border bg-gray-100 mb-3 gap-3">
                        <i class="fa-solid fa-circle-info mt-1"></i>
                        <p class="text-xs">A time-based link only lasts for a certain period of time. When it
                            expires, it will no longer be accessible.</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="expiration_date" class="font-bold">Expiration Date</label>
                        <input type="datetime-local" name="expiration_date" id="expiration_date"
                            class="rounded-lg w-full border-2 focus:outline-none focus:ring-0 focus:border-blue-600 border-gray-300 placeholder:text-gray-300 font-medium"
                            placeholder="_________">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-1 w-full lg:w-[30rem] bg-white p-4 rounded-b-lg  text-gray-600">
            <button
                class="text-sm bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg font-semibold transition">Shorten
                it!</button>
        </div>
    </form>
</div>

@push('quick-link-scripts')
    <script>
        const quickLinkBtn = document.getElementById('quick-access-btn')
        const quickLinkForm = document.getElementById('quick-link-form')
        const closeBtn = document.getElementById('close-btn')
        const passwordBtn = document.getElementById('password-btn')
        const expiredBtn = document.getElementById('expired-btn')
        const passwordAccor = document.getElementById('password-accor')
        const expiredAccor = document.getElementById('expired-accor')

        quickLinkBtn.addEventListener('click', function() {
            quickLinkForm.classList.toggle('hidden')
        })
        closeBtn.addEventListener('click', function() {
            quickLinkForm.classList.toggle('hidden')
        })

        passwordBtn.addEventListener('click', function() {
            passwordAccor.classList.toggle('hidden')
            expiredAccor.classList.add('hidden')
        })

        expiredBtn.addEventListener('click', function() {
            expiredAccor.classList.toggle('hidden')
            passwordAccor.classList.add('hidden')
        })
    </script>
@endpush
