<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-ld-navbar">
    @include('partial.toast')
    @include('partial.modal')

    <nav class="bg-navbar">
        <div class="container mx-auto flex flex-row justify-between items-center h-[100px] px-4 lg:px-[100px]">
            <a href="/" class="flex items-center">
                <img src="{{ asset('img/logo.png') }}" class="min-w-[130px] h-[70px]" alt="" />
            </a>
            <div class="flex flex-row items-center ">
                <div class="hidden justify-between items-center w-full md:flex md:w-auto z-[0] absolute md:static top-[90px] left-0 right-0" id="mobile-menu-2">
                    <ul class="flex flex-col p-4 bg-ld-navbar md:flex-row md:gap-5">
                        <li>
                            <a href="{{ route('tentang.kami') }}" class="block py-2 pr-4 pl-3 text-ld-green font-medium">Tentang Kami</a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 pr-4 pl-3 text-ld-green font-medium">Bahasa</a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 pr-4 pl-3 text-ld-green font-medium">Kontak</a>
                        </li>
                    </ul>
                </div>
                <div class="flex items-center">
                    @if (Auth::user())
                        <button type="button" class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="{{ url('storage/profile', Auth::user()->profile_picture) }}" alt="">
                        </button>
                        <div class="hidden z-60 my-4 text-base list-none bg-white divide-y divide-gray-100" id="user-dropdown">
                            <div class="py-3 px-4">
                                <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                                <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400 mb-2">{{ Auth::user()->email }}</span>
                                <a href="{{ route('profile') }}" class="text-white bg-ld-yellow hover:bg-ld-yellow shadow-lg font-medium rounded-lg text-sm px-3 py-1 focus:outline-none">Sunting Profil</a>
                            </div>
                            <ul class="py-1" aria-labelledby="user-menu-button">
                                <li>
                                    <a class="block py-2 px-4 text-lg text-ld-red hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa-solid fa-power-off"></i> Keluar</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button id="gabung" type="button" class="text-white bg-ld-yellow hover:bg-ld-yellow shadow-lg font-medium rounded-lg text-sm px-3 py-1 ml-5 focus:outline-none">Gabung</button>
                    @endif
                    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden focus:outline-none" aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <nav class="flex flex-col bg-ld-green w-full items-center whitespace-nowrap z-10">
        <div class="flex flex-row w-full h-[70px] overflow-auto">
            <div class="container mx-auto flex flex-row gap-5 items-center text-white-1 px-4 lg:px-[100px]">
                <a href="{{ route('home') }}" class="font-base pr-4 hover:text-ld-yellow">Home</a>
                <a data-dropdown-toggle="bankDrobdown" class="font-base px-4 hover:text-ld-yellow cursor-pointer">Bank</a>
                <div id="bankDrobdown" class="hidden z-10 w-44 font-normal bg-ld-green">
                    <ul class="py-1 text-sm" aria-labelledby="dropdownLargeButton">
                        <li>
                            <a href="{{ route('bank.variable') }}" class="block py-2 px-4 hover:text-ld-yellow">Variable Used</a>
                        </li>
                        <li>
                            <a href="{{ route('bank.data') }}" class="block py-2 px-4 hover:text-ld-yellow">Data</a>
                        </li>
                        <li>
                            <a href="{{ route('bank.theoritical') }}" class="block py-2 px-4 hover:text-ld-yellow">Theoritical Framework</a>
                        </li>
                        <li>
                            <a href="{{ route('bank.theheatmap') }}" class="block py-2 px-4 hover:text-ld-yellow">The Heat Map</a>
                        </li>
                        <li>
                            <a href="{{ route('bank.visualization') }}" class="block py-2 px-4 hover:text-ld-yellow">Visualization</a>
                        </li>
                    </ul>
                </div>
                <a data-dropdown-toggle="macroDrobdown" class="font-base px-4 hover:text-ld-yellow cursor-pointer">Macro</a>
                <div id="macroDrobdown" class="hidden z-10 w-44 font-normal bg-ld-green">
                    <ul class="py-1 text-sm" aria-labelledby="dropdownLargeButton">
                        <li>
                            <a href="{{ route('macro.variable') }}" class="block py-2 px-4 hover:text-ld-yellow">Variable Used</a>
                        </li>
                        <li>
                            <a href="{{ route('macro.data') }}" class="block py-2 px-4 hover:text-ld-yellow">Data</a>
                        </li>
                        <li>
                            <a href="{{ route('macro.theoritical') }}" class="block py-2 px-4 hover:text-ld-yellow">Theoritical Framework</a>
                        </li>
                        <li>
                            <a href="{{ route('macro.theheatmap') }}" class="block py-2 px-4 hover:text-ld-yellow">The Heat Map</a>
                        </li>
                        <li>
                            <a href="{{ route('macro.visualization') }}" class="block py-2 px-4 hover:text-ld-yellow">Visualization</a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('integration') }}" class="text-white-1 font-base px-4 hover:text-ld-yellow">Integrasi Bank & Macro</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="w-full bg-ld-green pt-[50px]">
        <div class="container mx-auto grid grid-cols-1 gap-10 md:grid-cols-3 px-4 lg:px-[100px]">
            <div class="w-full flex flex-row mt-3">
                <img src="{{ asset('img/logo.png') }}" class="min-w-[130px] h-[70px]" alt="" />
            </div>
            <div class="flex flex-col gap-2 w-full text-white-1">
                <span class="text-[22px] font-medium">Layanan Kami</span>
                <div class="grid grid-flow-col auto-cols-max">
                    <span class="w-[80px]">Phone 1</span>
                    <span class="w-[10px]">:</span>
                    <span>852232212</span>
                </div>
                <div class="grid grid-flow-col auto-cols-max">
                    <span class="w-[80px]">Phone 2</span>
                    <span class="w-[10px]">:</span>
                    <span>0852232212</span>
                </div>
                <div class="grid grid-flow-col auto-cols-max">
                    <span class="w-[80px]">Email</span>
                    <span class="w-[10px]">:</span>
                    <span>example@mail.com</span>
                </div>
            </div>
            <div class="flex flex-col gap-2 w-full text-white-1">
                <span class="text-[22px] font-medium">Ikuti Kami</span>
                <div class="flex flex-row gap-4">
                    <div class="flex flex-col text-center">
                        <a href="#"><i class="fa-brands fa-square-facebook fa-3x mb-1"></i></a>
                        <span>Facebook</span>
                    </div>
                    <div class="flex flex-col text-center">
                        <a href="#"><i class="fa-brands fa-square-twitter fa-3x mb-1"></i></a>
                        <span>Twitter</span>
                    </div>
                    <div class="flex flex-col text-center">
                        <a href="#"><i class="fa-brands fa-instagram fa-3x mb-1"></i></a>
                        <span>Intagram</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center w-full text-[12px] text-white-1 bg-black-1 mt-[50px] p-5">
            <span>Hak Cipta SIP 2022 | Peta Situs</span>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $(document).ready(function() {

            const gabung = document.getElementById('gabung')

            const formLoginModal = document.getElementById('formLoginModal')
            const formLoginModalClose = document.getElementById('formLoginModalClose')

            const formRegisterModal = document.getElementById('formRegisterModal')
            const formRegisterModalClose = document.getElementById('formRegisterModalClose')

            const formResetModal = document.getElementById('formResetModal')
            const formResetModalClose = document.getElementById('formResetModalClose')

            const formChangeModal = document.getElementById('formChangeModal')
            const formChangeModalClose = document.getElementById('formChangeModalClose')

            /**
             * Show Login Form
             */
            const message = `{{ Session::get('message') }}`
            if (message === 'login') {
                modal(formLoginModal, null, 1)
            }

            /**
             * Show Change Password Form
             */
            const token = `{{ request()->token }}`
            const email = `{{ request()->email }}`
            if (token && email) {
                modal(formChangeModal, null, 1)
            }

            /**
             * Form Modal
             */
            function modal(id, options, action) {
                const modal = new Modal(id, {
                    placement: 'center'
                })
                if (action === 0) {
                    modal.hide()
                    $('[modal-backdrop]').remove()
                }
                if (action === 1) modal.show()
            }

            $(gabung).on('click', function() {
                modal(formLoginModal, null, 1)
            })
            $(formLoginModalClose).on('click', function() {
                modal(formLoginModal, null, 0)
            })
            $(formRegisterModalClose).on('click', function() {
                modal(formRegisterModal, null, 0)
            })
            $(formResetModalClose).on('click', function() {
                modal(formResetModal, null, 0)
            })

            window.daftarDisini = daftarDisini
            window.lupaPassword = lupaPassword
            window.masukDisiniRegister = masukDisiniRegister
            window.masukDisiniReset = masukDisiniReset
            window.masukDisiniChange = masukDisiniChange

            function daftarDisini() {
                modal(formLoginModal, null, 0)
                modal(formRegisterModal, null, 1)
            }

            function lupaPassword() {
                modal(formLoginModal, null, 0)
                modal(formResetModal, null, 1)
            }

            function masukDisiniRegister() {
                modal(formRegisterModal, null, 0)
                modal(formLoginModal, null, 1)
            }

            function masukDisiniReset() {
                modal(formResetModal, null, 0)
                modal(formLoginModal, null, 1)
            }

            function masukDisiniChange() {
                window.location = '/'
            }

            /**
             * Authentication
             */
            $('#formLogin').on('submit', async function(e) {
                loadingButton(true, '#submitLogin', '')

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

                    if (data.code === 400) {
                        if (data.data.email) {
                            $('#emailLogin').addClass('border-red-500')
                            $('#emailLoginMsg').removeClass('hidden').text(data.data.email[0])
                        }
                        if (data.data.password) {
                            $('#passwordLogin').addClass('border-red-500')
                            $('#passwordLoginMsg').removeClass('hidden').text(data.data.password[0])
                        }
                    } else if (data.code === 500) {
                        if (data.message) {
                            $('#emailLogin').addClass('border-red-500')
                            $('#emailLoginMsg').removeClass('hidden').text(data.message)
                        }
                    } else {
                        window.location = ''
                    }
                } catch (error) {
                    toast('danger', error.message)
                }

                this.reset()
                loadingButton(false, '#submitLogin', 'Masuk')
            })

            $('#formRegister').on('submit', async function(e) {
                loadingButton(true, '#submitRegister', '')

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

                    if (data.code === 400) {
                        if (data.data.name) {
                            $('#nameRegister').addClass('border-red-500')
                            $('#nameRegisterMsg').removeClass('hidden').text(data.data.name[0])
                        }
                        if (data.data.username) {
                            $('#usernameRegister').addClass('border-red-500')
                            $('#usernameRegisterMsg').removeClass('hidden').text(data.data.username[0])
                        }
                        if (data.data.email) {
                            $('#emailRegister').addClass('border-red-500')
                            $('#emailRegisterMsg').removeClass('hidden').text(data.data.email[0])
                        }
                        if (data.data.password) {
                            $('#passwordRegister').addClass('border-red-500')
                            $('#passwordRegisterMsg').removeClass('hidden').text(data.data.password[0])
                        }
                    } else {
                        window.location = ''
                    }
                } catch (error) {
                    toast('danger', error.message)
                }

                loadingButton(false, '#submitRegister', 'Daftar')
            })

            $('#formResetPassword').on('submit', async function(e) {
                loadingButton(true, '#submitResetPassword', '')

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

                    if (data.code === 400) {
                        if (data.data.email) {
                            $('#emailReset').addClass('border-red-500')
                            $('#emailResetMsg').removeClass('hidden').text(data.data.email[0])
                        }
                    } else if (data.code === 500) {
                        if (data.data.email) {
                            $('#emailReset').addClass('border-red-500')
                            $('#emailResetMsg').removeClass('hidden').text(data.data.email)
                        }
                    } else {
                        modal(formResetModal, null, 0)
                        toast('success', data.message)
                    }
                } catch (error) {
                    toast('danger', error.message)
                }

                this.reset()
                loadingButton(false, '#submitResetPassword', 'Masuk')
            })

            $('#formChangePassword').on('submit', async function(e) {
                loadingButton(true, '#submitChangePassword', '')

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

                    if (data.code === 400) {
                        if (data.data.email) {
                            $('#emailChange').addClass('border-red-500')
                            $('#emailChangeMsg').removeClass('hidden').text(data.data.email[0])
                        }
                        if (data.data.password) {
                            $('#passwordChange').addClass('border-red-500')
                            $('#passwordChangeMsg').removeClass('hidden').text(data.data.password[0])
                        }
                    } else if (data.code === 500) {
                        if (data.data.email) {
                            $('#emailChange').addClass('border-red-500')
                            $('#emailChangeMsg').removeClass('hidden').text(data.data.email)
                        }
                    } else {
                        modal(formChangeModal, null, 0)
                        toast('success', data.message)
                    }
                } catch (error) {
                    toast('danger', error.message)
                }

                this.reset()
                loadingButton(false, '#submitChangePassword', 'Masuk')
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

            /**
             * Toast
             */
            function toast(type, message) {
                if (type === 'success') {
                    toastr.success(message)
                }
                if (type === 'danger') {
                    toastr.error(message)
                }
                if (type === 'warning') {
                    toastr.warning(message)
                }
            }
        })
    </script>

    @stack('scripts')
</body>

</html>
