@extends('template.landing')

@section('content')
    <section class="grid grid-col-1 md:grid-flow-col gap-4 container mx-auto px-4 py-10 lg:px-[100px]  py-4 md:py-10">
        <div class="flex flex-col justify-between gap-4">
            <div class="w-full md:min-w-[250px] bg-white rounded-lg border border-gray-200 shadow-md">
                <div class="flex flex-col items-center p-6 pt-10">
                    <div class="relative">
                        <img id="profile" class="mb-3 w-[80px] h-[80px] rounded-full shadow-lg border-lg border-ld-green" src="{{ url('storage/profile', Auth::user()->profile_picture) }}" alt="" />
                        <span id="picture" class="absolute text-center bottom-[15px] left-[60px] transform translate-y-1/1 w-[23px] h-[23px] bg-ld-yellow rounded-full cursor-pointer"><i class="fa-solid fa-pen text-ld-white fa-xs"></i></span>
                        <form enctype="multipart/form-data" action="{{ route('profile.upload') }}" method="POST">
                            <input id="file" type="file" name="file" style="display:none" />
                        </form>
                    </div>
                    <h5 class="mb-2 text-md font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</span>
                </div>
            </div>
            <div class="flex flex-col justify-between w-full h-full bg-white rounded-lg border border-gray-200 shadow-md row-span-1">
                <div>

                </div>
                <div class="flex flex-col w-full h-[80px] justify-center items-center bg-gray-100">
                    <span data-modal-toggle="confirmDeleteModal" class="text-ld-red font-medium text-sm cursor-pointer"><i class="fa-regular fa-trash-can"></i> Hapus Akun</span>
                </div>
            </div>
        </div>

        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md flex flex-col">
            <div class="w-full px-6 py-4 border-b border-gray-200">
                <span class="font-medium text-[28px]">Data Akun</span>
            </div>
            <form id="formUpdate" action="{{ route('profile.update') }}">
                <div class="w-full p-6 grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div id="formContent">
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">Nama Pengguna</label>
                            <input id="name" type="text" name="name" value="{{ Auth::user()->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5" required>
                            <span id="nameMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-normal">Alamat Lengkap</label>
                            <input id="address" type="text" name="address" value="{{ Auth::user()->address }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5">
                            <span id="addressMsg" class="hidden mt-2 text-xs text-red-500"></span>
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
                            <input id="password" type="password" name="password" value="" placeholder="•••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-ld-yellow focus:border-ld-yellow block w-full p-2.5">
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
                                <label class="inline-flex relative items-center cursor-pointer">
                                    <input id="emailNotification" type="checkbox" name="email_notification" value="{{ Auth::user()->email_notification }}" class="sr-only peer" @if (Auth::user()->email_notification) checked @endif>
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-ld-yellow"></div>
                                </label>
                            </div>
                            <span id="emailNotificationMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                    </div>
                </div>
                <div class="w-full h-[80px] flex flex-row justify-end items-center gap-2 px-6 py-4 bg-gray-100">
                    <button class="text-ld-yellow bg-ld-white hover:bg-ld-white shadow-lg font-base rounded-lg text-sm px-3 py-1 border border-ld-yellow focus:outline-none">Batal</button>
                    <button id="submitUpdate" type="submit" class="text-white bg-ld-yellow hover:bg-ld-yellow shadow-lg font-base rounded-lg text-sm px-3 py-1 focus:outline-none">Mengatur Ulang</button>
                </div>
            </form>
        </div>
    </section>

    <div id="confirmDeleteModal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="confirmDeleteModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah anda yakin ingin menghapus akun?</h3>
                    <button id="hapusAkun" data-modal-toggle="confirmDeleteModal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Ya
                    </button>
                    <button data-modal-toggle="confirmDeleteModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            /**
             * Upload Photo
             */
            $('#picture').on('click', function() {
                $('#file').trigger('click')
            })

            $('#file').on('change', async function() {

                let files = $('#file')[0].files

                let fd = new FormData();
                fd.append('file', files[0])

                const post = await axios({
                    method: 'post',
                    url: '/profile/upload',
                    headers: {},
                    data: fd
                })

                const data = post.data
                const img = `{{ url('storage/profile', Auth::user()->profile_picture) }}`
                if (data.code === 200) {
                    $('#profile').removeAttr("src")
                    $('#profile').attr('src', img + "?timestamp=" + new Date().getTime())
                    toastr.success(data.message)
                } else {
                    toastr.error(data.message)
                }
            })

            /**
             * Delete Akun
             */
            $('#hapusAkun').on('click', async function() {

                const post = await axios({
                    method: 'post',
                    url: '/profile/delete',
                    headers: {},
                    data: {}
                })

                const data = post.data

                if (data.code === 200) {
                    window.location = '/'
                } else {
                    toastr.error(data.message)
                }
            })

            $('#emailNotification').on('click', function() {
                if ($('#emailNotification').is(":checked")) {
                    this.value = '1'
                } else {
                    this.value = '0'
                }
            })

            /**
             * Update
             */
            $('#formUpdate').on('submit', async function(e) {
                loadingButton(true, '#submitUpdate', '')

                try {
                    e.preventDefault()

                    const form = $(e.target);
                    const post = await axios({
                        method: 'post',
                        url: form.attr("action"),
                        headers: {},
                        data: form.serialize()
                    })

                    const data = post.data

                    if (data.code === 200) {
                        const route = `{{ route('profile') }}`
                        $("#formContent").load(route + " #formContent")
                        toastr.success(data.message)
                    } else if (data.code === 400) {
                        if (data.data.name) {
                            $('#name').addClass('border-red-500')
                            $('#nameMsg').removeClass('hidden').text(data.data.name[0])
                        }
                        if (data.data.address) {
                            $('#address').addClass('border-red-500')
                            $('#addressMsg').removeClass('hidden').text(data.data.address[0])
                        }
                        if (data.data.email) {
                            $('#email').addClass('border-red-500')
                            $('#emailMsg').removeClass('hidden').text(data.data.email[0])
                        }
                        if (data.data.password) {
                            $('#password').addClass('border-red-500')
                            $('#passwordMsg').removeClass('hidden').text(data.data.password[0])
                        }
                        if (data.data.email_notification) {
                            $('#emailNotification').addClass('border-red-500')
                            $('#emailNotificationMsg').removeClass('hidden').text(data.data.email_notification[0])
                        }
                    } else {
                        toastr.warning(data.message)
                    }
                } catch (error) {
                    toastr.error(error.message)
                }

                loadingButton(false, '#submitUpdate', 'Mengatur Ulang')
            })

            /**
             * Loading Button
             */
            function loadingButton(loading, el, text) {
                if (loading) {
                    $(el).prop("disabled", true);
                    $(el).html(`<svg aria-hidden="true" role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Loading...`);
                } else {
                    $(el).prop("disabled", false);
                    $(el).html(text);
                }
            }
        })
    </script>
@endpush
