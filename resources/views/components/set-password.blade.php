<div id="pashphrase-modal-{{ $link->id }}"
    class="w-full hidden h-screen bg-gray-800 bg-opacity-30 items-center justify-center fixed top-0 right-0 z-[9999] !mt-0">
    <div class="w-[30rem] bg-white p-4 shadow-lg rounded-lg">
        <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center">
                <i class="fa-solid fa-clock text-lg"></i>
                <p class="font-semibold text-xl">Protected Link</p>
            </div>
            <button id="closeIcon-{{ $link->id }}" class="h-8 w-8 flex items-center justify-center">
                <i class="fa-solid fa-xmark text-2xl hover:cursor-pointer"></i>
            </button>
        </div>
        <div class="w-full flex items-start p-2 border gap-2 bg-gray-100 mt-3">
            <i class="fa-solid fa-circle-info text-sm mt-1"></i>
            <p class="text-sm">A protected link can be given a secret key/passphrase for access before being redirected
                to the original link</p>
        </div>

        @if ($link->password)
            <div class="flex flex-col gap-1 text-sm mt-2 p-2 border bg-teal-100 text-teal-700">
                <h2 class=" font-bold">Pashphrase has been set</h2>
                <p>Input the new Pashphrase and click "Change Key" to change new Pashphrase or "Remove" to return
                    the link to its public form.
                </p>
            </div>
        @endif

        <form action="{{ route('links.updatePashphrase', $link->id) }}" method="POST" class="mt-3">
            @csrf
            @method('put')
            <div class="flex flex-col space-y-2">
                <label for="pashphrase-{{ $link->id }}" class="font-semibold text-sm">Pashphrase</label>
                <div class="w-full relative">
                    <input type="password" id="pashphrase-{{ $link->id }}" name="pashphrase"
                        value="{{ old('pashphrase') }}" placeholder="________"
                        class="placeholder:text-gray-400 border-gray-300 rounded-lg w-full">
                    <i id="eye-icon-{{ $link->id }}"
                        class="fa-solid fa-eye text-xl absolute top-1/2 -translate-y-1/2 right-4 text-gray-400 hover:text-blue-600 transition hover:cursor-pointer"></i>
                </div>
            </div>



            <div
                class="flex items-center  mt-5 @if ($link->password) justify-between @else justify-end @endif">
                @if ($link->password)
                    <button type="submit" formaction="{{ route('links.removePashphrase', $link->id) }}"
                        class="py-2 text-sm px-4 rounded-lg font-medium bg-red-600 text-white hover:bg-red-700 transition">
                        Remove it
                    </button>
                @endif


                <div class="flex items-center justify-center gap-3">
                    <button id="closePashphraseBtn-{{ $link->id }}" type="button"
                        class="py-2 text-sm px-4 rounded-lg font-medium bg-gray-100 hover:bg-gray-200 transition">
                        Close
                    </button>

                    @if ($link->password)
                        <button type="submit"
                            class="py-2 text-sm px-4 rounded-lg font-medium bg-blue-600 text-white hover:bg-blue-700 transition">
                            Change Key
                        </button>
                    @else
                        <button type="submit"
                            class="py-2 text-sm px-4 rounded-lg font-medium bg-blue-600 text-white hover:bg-blue-700 transition">
                            Save
                        </button>
                    @endif
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    const pashphraseBtn{{ $link->id }} = document.getElementById(
        'pashphraseBtn-{{ $link->id }}');
    const pashphraseModal{{ $link->id }} = document.getElementById(
        "pashphrase-modal-{{ $link->id }}"
    )
    const closePashphraseBtn{{ $link->id }} = document.getElementById(
        'closePashphraseBtn-{{ $link->id }}'
    )
    const closeIcon{{ $link->id }} = document.getElementById(
        'closeIcon-{{ $link->id }}'
    )

    const eyeIcon{{ $link->id }} = document.getElementById(
        'eye-icon-{{ $link->id }}'
    )

    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {

            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');

        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    eyeIcon{{ $link->id }}.addEventListener('click', function() {
        togglePassword('pashphrase-{{ $link->id }}', 'eye-icon-{{ $link->id }}');
    });


    pashphraseBtn{{ $link->id }}.addEventListener('click', function() {
        pashphraseModal{{ $link->id }}.classList.remove('hidden');
        pashphraseModal{{ $link->id }}.classList.add('flex');
    });

    closePashphraseBtn{{ $link->id }}.addEventListener('click', function() {
        pashphraseModal{{ $link->id }}.classList.remove('flex');
        pashphraseModal{{ $link->id }}.classList.add('hidden');
    });

    closeIcon{{ $link->id }}.addEventListener('click', function() {
        pashphraseModal{{ $link->id }}.classList.remove('flex');
        pashphraseModal{{ $link->id }}.classList.add('hidden');
    })
</script>
