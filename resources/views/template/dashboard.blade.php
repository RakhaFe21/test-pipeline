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

<body>
    @include('partial.toast')

    <main class="flex flex-row h-screen">
        <aside class="fixed top-0 left-0 bottom-0 py-5 px-5 bg-black-2 w-[360px] overflow-auto">
            <div class="flex bg-gray-3 rounded-xl">
                <div class="py-3 px-4 bg-gray-2 rounded-l-xl rounded-br-[20px]">
                    <div class="flex items-center space-x-4">
                        <img class="w-10 h-10 rounded-full bg-white-1" src="{{ url('storage/profile', Auth::user()->profile_picture) }}" alt="">
                        <div class="font-medium">
                            <div class="text-white-1">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-white-1">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center p-4 pl-2 w-full text-base font-normal text-gray-1">
                <span class="flex-1 ml-2 text-left whitespace-nowrap">Overview</span>
            </div>
            <ul class="space-y-2">
                <li>
                    <button type="button" class="flex items-center p-2 w-full text-base font-normal text-white-1 rounded-lg transition duration-75 group bg-blue-1 hover:bg-blue-1 hover:text-white-1" data-collapse-toggle="banking-dropdown">
                        <div class="flex justify-center w-[28px] h-[28px]">
                            <img class="p-1 bg-white-1 rounded-full" src="{{ asset('img/icon-banking.png') }}" alt="">
                        </div>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Banking</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="banking-dropdown" class="py-2 space-y-2">
                        <li>
                            <a href="{{ route('dashboard.bank.variable') }}" class="flex items-center p-2 pl-2 w-full text-base font-normal text-gray-1 hover:text-blue-1 rounded-lg transition duration-75 group ">
                                <div class="flex justify-center w-[28px] h-[28px]">
                                    <img class="p-1 rounded-full" src="{{ asset('img/icon-variable.png') }}" alt="">
                                </div>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Variable</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.bank.data') }}" class="flex items-center p-2 pl-2 w-full text-base font-normal text-gray-1 hover:text-blue-1 rounded-lg transition duration-75 group ">
                                <div class="flex justify-center w-[28px] h-[28px]">
                                    <img class="p-1 rounded-full" src="{{ asset('img/icon-variable.png') }}" alt="">
                                </div>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Data</span>
                            </a>
                        </li>
                        <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-1 rounded-lg transition duration-75 group hover:text-blue-1" aria-controls="data-dropdown" data-collapse-toggle="data-dropdown">
                            <img class="p-1 rounded-full" src="{{ asset('img/icon-ibri.png') }}" alt="">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="data-dropdown">Step IBRI</span>
                            <svg sidebar-toggle-item="data-dropdown" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="data-dropdown" class="hidden py-2 space-y-2"></ul>
                        <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-1 rounded-lg transition duration-75 group hover:text-blue-1" aria-controls="macro-dropdown" data-collapse-toggle="macro-dropdown">
                            <div class="flex justify-center w-[28px] h-[28px]">
                                <img class="p-1 rounded-full" src="{{ asset('img/icon-macro.png') }}" alt="">
                            </div>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="macro-dropdown">Macro</span>
                            <svg sidebar-toggle-item="macro-dropdown" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="macro-dropdown" class="hidden py-2 space-y-2"></ul>
                        <button type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-1 rounded-lg transition duration-75 group hover:text-blue-1" aria-controls="integrasi-dropdown" data-collapse-toggle="integrasi-dropdown">
                            <div class="flex justify-center w-[28px] h-[28px]">
                                <img class="p-1 rounded-full" src="{{ asset('img/icon-integrasi.png') }}" alt="">
                            </div>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item="integrasi-dropdown">Integrasi Bank & Macro</span>
                            <svg sidebar-toggle-item="integrasi-dropdown" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="integrasi-dropdown" class="hidden py-2 space-y-2"></ul>
                        <li>
                            <a href="#" class="flex items-center p-2 pl-2 w-full text-base font-normal text-gray-1 hover:text-blue-1 rounded-lg transition duration-75 group ">
                                <div class="flex justify-center w-[28px] h-[28px]">
                                    <img class="p-1 rounded-full" src="{{ asset('img/icon-variable.png') }}" alt="">
                                </div>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">User Data</span>
                            </a>
                        </li>
                        <li>
                            <button id="logout" class="flex cursor-pointer items-center p-2 pl-3 w-full text-base font-normal text-gray-1 hover:text-blue-1 rounded-lg transition duration-75 group">
                                <div class="flex flex-row items-center justify-center w-[28px] h-[28px]">
                                    <i class="fa-solid fa-right-from-bracket text-ds-blue"></i>
                                </div>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Logout</span>
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>
        <nav class="flex flex-row bg-white-1 justify-between items-center h-[110px] shadow-sm p-5 ml-[360px] fixed top-0 right-0 left-0">
            <div>
                <form>
                    <div class="flex">
                        <div class="relative w-[300px]">
                            <input type="text" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-100 rounded-lg border-gray-100 focus:border-none" placeholder="Search menu" required>
                            <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-1 rounded-lg border border-blue-1 hover:bg-blue-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex flex-row gap-4">
                <div class="bg-gray-100 p-2 rounded-lg cursor-pointer">
                    <svg class="w-6 h-6 text-gray-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="flex flex-row gap-1 items-center text-gray-1 bg-gray-100 p-2 rounded-lg cursor-pointer">
                    <span id="timer">00:00:00</span>
                    <svg class="w-6 h-6 text-gray-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </nav>
        <section class="flex flex-col w-full h-screen bg-white-1 pt-[110px] pl-[360px]">
            @yield('content')
        </section>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

    <script>
        $(document).ready(function() {

            /**
             * Set Menu List
             */
            const bankIbriMenuList = [{
                    "url": "{{ route('dashboard.bank.ibri.theoretical') }}",
                    "title": "Theoretical Framework"
                },
                {
                    "url": "{{ route('dashboard.bank.ibri.transforming') }}",
                    "title": "Transforming into Index"
                },
            ]

            Object.keys(bankIbriMenuList).forEach((key, index) => {
                $("#data-dropdown").append(`
                    <li>
                        <a href="${bankIbriMenuList[key].url}" class="flex items-center p-2 pl-3 w-full text-base font-normal text-gray-1 hover:text-blue-1 rounded-lg transition duration-75 group ">
                            <img class="p-1 rounded-full" src="{{ asset('img/icon-list.png') }}" alt="">
                            <span class="flex-1 ml-4 text-left whitespace-nowrap">${bankIbriMenuList[key].title}</span>
                        </a>
                    </li>
                `)
            })

            const bankingMacroChild = []

            Object.keys(bankingMacroChild).forEach((key, index) => {
                $("#macro-dropdown").append(`
                    <li>
                        <a href="dashboard/banking/macro/${bankingMacroChild[key].url}" class="flex items-center p-2 pl-3 w-full text-base font-normal text-gray-1 hover:text-blue-1 rounded-lg transition duration-75 group ">
                            <img class="p-1 rounded-full" src="{{ asset('img/icon-list.png') }}" alt="">
                            <span class="flex-1 ml-4 text-left whitespace-nowrap">${bankingMacroChild[key].title}</span>
                        </a>
                    </li>
                `)
            })

            const bankingIntegrasiChild = []

            Object.keys(bankingIntegrasiChild).forEach((key, index) => {
                $("#integrasi-dropdown").append(`
                    <li>
                        <a href="dashboard/banking/integrasi/${bankingIntegrasiChild[key].url}" class="flex items-center p-2 pl-3 w-full text-base font-normal text-gray-1 hover:text-blue-1 rounded-lg transition duration-75 group ">
                            <img class="p-1 rounded-full" src="{{ asset('img/icon-list.png') }}" alt="">
                            <span class="flex-1 ml-4 text-left whitespace-nowrap">${bankingIntegrasiChild[key].title}</span>
                        </a>
                    </li>
                `)
            })

            /**
             * Logout
             */
            window.logout = logout

            $('#logout').on('click', async function() {
                try {
                    const post = await axios({
                        method: 'post',
                        url: '{{ route('logout') }}',
                        headers: {},
                        data: {}
                    })

                    window.location = '{{ route('dashboard.home') }}'

                } catch (error) {
                    toastr.error(error.message)
                }
            })

            /**
             * Set Navbar Timer
             */
            setInterval(function() {
                const now = convert(new Date(), "{{ config('app.timezone') }}")
                document.getElementById("timer").innerHTML = `${now.getHours()}`.replace(/^(\d)$/, '0$1') + ":" + `${now.getMinutes()}`.replace(/^(\d)$/, '0$1') + ":" + `${now.getSeconds()}`.replace(/^(\d)$/, '0$1')
            }, 1000)

            function convert(date, timezone) {
                return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
                    timeZone: timezone
                }))
            }

            /**
             * Loading Button
             */
            window.loadingButton = loadingButton

            function loadingButton(loading, el, text) {
                if (loading) {
                    $(el).prop("disabled", true)
                    $(el).html(`<svg aria-hidden="true" role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Loading...`)
                } else {
                    $(el).prop("disabled", false)
                    $(el).html(text)
                }
            }

            /**
             * Form Modal
             */
            window.modal = modal

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

        })
    </script>
</body>

</html>
