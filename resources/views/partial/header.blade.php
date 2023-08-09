<header class="bg-center bg-cover bg-no-repeat bg-[url('/img/image-header.png')]">
    <div class="bg-ld-green bg-opacity-50 py-[100px]">
        <div class="container mx-auto flex flex-col text-white-1 px-4 lg:px-[100px]">
            <span class="font-medium text-[22px] text-white-2">Bank Indonesia</span>
            <span class="font-medium text-[40px]">{{ __('header.title') }}</span>
            <span class="font-medium text-[60px]">{{ __('header.banking') }} <span class="text-ld-red grow">Indonesia</span></span>

            <span class="text-white-2 text-[18px] max-w-[550px]">{{ __('header.description') }}</span>
            <div class="mt-5">
                <a href="{{ Auth::user() ? route('dashboard.home', 'id')  : '#'}}" class=" {{ Auth::user() ? '' : 'gabung' }} text-white bg-ld-yellow hover:bg-ld-yellow shadow-lg font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">{{ __('header.btn') }}</a>
            </div>
        </div>
    </div>
</header>
