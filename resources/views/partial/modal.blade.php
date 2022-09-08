<div id="formLoginModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-[450px] max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button id="formLoginModalClose" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                <i class="fa-solid fa-xmark"></i>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="flex flex-col p-6 space-y-6">
                <div class="flex flex-col w-full items-center">
                    <span class="font-medium text-[30px] mb-2">Masuk</span>
                    <p class="text-[14px]">
                        Belum Punya Akun? <span onclick="daftarDisini()" class="text-ld-yellow text-[14px] cursor-pointer">Daftar disini</span>
                    <p>
                </div>
                <div>
                    <form id="formLogin" method="POST" action="{{ route('auth.login') }}">
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">email</label>
                            <input id="emailLogin" type="text" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Input email" required>
                            <span id="emailLoginMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal text-gray-900">Password</label>
                            <input id="passwordLogin" type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="•••••••••" required>
                            <span id="passwordLoginMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="flex flex-row justify-between mb-4">
                            <div class="flex items-center"></div>
                            <span onclick="lupaPassword()" class="text-ld-yellow font-normal text-xs cursor-pointer">Lupa Password</span>
                        </div>
                        <button id="submitLogin" type="submit" class="text-white w-full bg-ld-yellow hover:bg-ld-yellow font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Masuk</button>
                        <div class="flex w-full justify-center mt-2 mb-5">
                            <span class="text-sm">Atau Masuk Dengan</span>
                        </div>
                        <div class="flex flex-row justify-between">
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-goole.png') }}" alt="" class="w-md h-md"> Google
                            </button>
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-facebook.png') }}" alt="" class="w-md h-md"> Facebook
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="formRegisterModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-[450px] max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button id="formRegisterModalClose" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                <i class="fa-solid fa-xmark"></i>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="flex flex-col p-6 space-y-6">
                <div class="flex flex-col w-full items-center">
                    <span class="font-medium text-[30px] mb-2">Daftar</span>
                    <p class="text-[14px]">
                        Sudah Punya Akun? <span onclick="masukDisiniRegister()" class="text-ld-yellow text-[14px] cursor-pointer">Masuk disini</span>
                    <p>
                </div>
                <div>
                    <form id="formRegister" method="POST" action="{{ route('auth.register') }}">
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">Nama</label>
                            <input id="nameRegister" type="text" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Masukkan Nama" required>
                            <span id="nameRegisterMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">Username</label>
                            <input id="usernameRegister" type="text" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Masukkan Username" required>
                            <span id="usernameRegisterMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">Email</label>
                            <input id="emailRegister" type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Masukkan Email" required>
                            <span id="emailRegisterMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal text-gray-900">Password</label>
                            <input id="passwordRegister" type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Buat Password" required>
                            <span id="passwordRegisterMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5" placeholder="Konfirmasi Password" required>
                        </div>
                        <button id="submitRegister" type="submit" class="text-white w-full bg-ld-yellow hover:bg-ld-yellow font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Daftar</button>
                        <div class="flex w-full justify-center mt-2 mb-5">
                            <span class="text-sm">Atau Masuk Dengan</span>
                        </div>
                        <div class="flex flex-row justify-between">
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-goole.png') }}" alt="" class="w-md h-md"> Google
                            </button>
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-facebook.png') }}" alt="" class="w-md h-md"> Facebook
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="formResetModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-[450px] max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button id="formResetModalClose" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                <i class="fa-solid fa-xmark"></i>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="flex flex-col p-6 space-y-6">
                <div class="flex flex-col w-full items-center">
                    <span class="font-medium text-[30px] mb-2">Reset Password</span>
                    <p class="text-[14px]">
                        Sudah Punya Akun? <span onclick="masukDisiniReset()" class="text-ld-yellow text-[14px] cursor-pointer">Masuk disini</span>
                    <p>
                </div>
                <div>
                    <form id="formResetPassword" method="POST" action="{{ route('auth.resetPassword') }}">
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">Email</label>
                            <input id="emailReset" type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Masukkan Email" required>
                            <span id="emailResetMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <button id="submitResetPassword" type="submit" class="text-white w-full bg-ld-yellow hover:bg-ld-yellow font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Reset Password</button>
                        <div class="flex w-full justify-center mt-2 mb-5">
                            <span class="text-sm">Atau Masuk Dengan</span>
                        </div>
                        <div class="flex flex-row justify-between">
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-goole.png') }}" alt="" class="w-md h-md"> Google
                            </button>
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-facebook.png') }}" alt="" class="w-md h-md"> Facebook
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="formChangeModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-[450px] max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button id="formChangeModalClose" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                <i class="fa-solid fa-xmark"></i>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="flex flex-col p-6 space-y-6">
                <div class="flex flex-col w-full items-center">
                    <span class="font-medium text-[30px] mb-2">Ganti Password</span>
                    <p class="text-[14px]">
                        Sudah Punya Akun? <span onclick="masukDisiniChange()" class="text-ld-yellow text-[14px] cursor-pointer">Masuk disini</span>
                    <p>
                </div>
                <div>
                    <form id="formChangePassword" method="POST" action="{{ route('auth.updatePassword') }}">
                        <input type="hidden" name="token" value="{{ request()->token }}">
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">Email</label>
                            <input id="emailChange" type="email" name="email" value="{{ request()->email }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Masukkan Email" required>
                            <span id="emailChangeMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal text-gray-900">Password</label>
                            <input id="passwordChange" type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" placeholder="Buat Password" required>
                            <span id="passwordChangeMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5" placeholder="Konfirmasi Password" required>
                        </div>
                        <button id="submitChangePassword" type="submit" class="text-white w-full bg-ld-yellow hover:bg-ld-yellow font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Simpan</button>
                        <div class="flex w-full justify-center mt-2 mb-5">
                            <span class="text-sm">Atau Masuk Dengan</span>
                        </div>
                        <div class="flex flex-row justify-between">
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-goole.png') }}" alt="" class="w-md h-md"> Google
                            </button>
                            <button type="button" class="flex flex-row gap-1 items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:outline-none font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2">
                                <img src="{{ asset('img/icon-facebook.png') }}" alt="" class="w-md h-md"> Facebook
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
