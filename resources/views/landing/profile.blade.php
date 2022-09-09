@extends('template.landing')

@section('content')
    <section class="grid grid-col-1 md:grid-flow-col gap-4 px-4 md:px-[100px] py-4 md:py-10">
        <div class="flex flex-col justify-between gap-4">
            <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
                <div class="flex justify-end px-2 py-2">
                    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                        <span class="sr-only">Open dropdown</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </button>
                    <div id="dropdown" class="hidden z-10 w-44 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                        <ul class="py-1" aria-labelledby="dropdownButton">
                            <li>
                                <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col items-center p-6">
                    <img class="mb-3 w-[70px] h-[70px] rounded-full shadow-lg" src="{{ asset('storage/profile.png') }}" alt="" />
                    <h5 class="mb-1 text-md font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</span>
                </div>
            </div>
            <div class="flex flex-col justify-between w-full h-full bg-white rounded-lg border border-gray-200 shadow-md row-span-1">
                <div>

                </div>
                <div class="w-full items-center text-center gap-2 px-6 py-5 bg-gray-100">
                    <span id="hapusAkun" class="text-ld-red font-medium text-sm cursor-pointer"><i class="fa-regular fa-trash-can"></i> Hapus Akun</span>
                </div>
            </div>
        </div>

        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md flex flex-col">
            <div class="w-full px-6 py-4 border-b border-gray-200">
                <span class="font-medium text-[30px]">Data Akun</span>
            </div>
            <div class="w-full p-6 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-normal">Nama Pengguna</label>
                        <input id="name" type="text" name="name" value="{{ Auth::user()->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" required>
                        <span id="nameMsg" class="hidden mt-2 text-xs text-red-500"></span>
                    </div>
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-normal">Alamat Lengkap</label>
                        <input id="alamat" type="text" name="alamat" value="{{ Auth::user()->alamat }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" required>
                        <span id="alamatMsg" class="hidden mt-2 text-xs text-red-500"></span>
                    </div>
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-normal">Email</label>
                        <input id="email" type="text" name="email" value="{{ Auth::user()->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" required>
                        <span id="emailMsg" class="hidden mt-2 text-xs text-red-500"></span>
                    </div>
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-normal">Password Lama</label>
                        <input disabled type="text" value="•••••••••" class="bg-ld-yellow/50 border border-ld-yellow text-ld-white text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" required>
                    </div>
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-normal">Password Baru</label>
                        <input id="password" type="password" name="password" value="" placeholder="•••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" required>
                        <span id="passwordMsg" class="hidden mt-2 text-xs text-red-500"></span>
                    </div>
                    <div class="mb-5">
                        <p class="text-xs"><span class="font-medium">Tentang perlindungan data : </span>kami menyimpan data anda untuk meningkatkan layanan kami dan memberikan informasi update seputar informasi penilaian perbankan saat ini.</p>
                    </div>
                </div>
                <div>
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-normal">Pemberitahuan email</label>
                        <div class="flex flex-row justify-between items-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl p-2">
                            <span>Beritahu saya jika ada informasi terbaru</span>
                            <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" value="" id="default-toggle" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-ld-yellow"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-row justify-end gap-2 px-6 py-4 bg-gray-100">
                <button class="text-ld-yellow bg-ld-white hover:bg-ld-white shadow-lg font-base rounded-lg text-sm px-3 py-1 border border-ld-yellow focus:outline-none">Batal</button>
                <button class="text-white bg-ld-yellow hover:bg-ld-yellow shadow-lg font-base rounded-lg text-sm px-3 py-1 focus:outline-none">Mengatur Ulang</button>
            </div>
        </div>
    </section>
@endsection
