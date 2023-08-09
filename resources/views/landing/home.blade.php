@extends('template.landing')

@section('content')
    @include('partial.header')

    <section class="container mx-auto py-[50px] px-4 py-10 lg:px-[100px] ">
        <div class="flex flex-col items-center content-center text-center">
            <span class="font-medium text-[30px] text-ld-green">{{ __('home.title') }}</span>
            <span class="font-medium text-[18px] text-ld-red">{{ __('home.sub_title') }}</span>
            <span class="text-[18px] max-w-[500px]">{{ __('home.description') }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-[50px]">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                    <a href="#"><span>Variable</span></a>
                </div>
                <div class="p-5">
                    <span>{{ __('home.variable') }}</span>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                    <a href="#"><span>Data</span></a>
                </div>
                <div class="p-5">
                    <span>{{ __('home.data') }}</span>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                    <a href="#"><span>Theoritical Framework</span></a>
                </div>
                <div class="p-5">
                    <span>{{ __('home.theoritical') }}</span>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                    <a href="#"><span>The Heat Map</span></a>
                </div>
                <div class="p-5">
                    <span>{{ __('home.heat_map') }}</span>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                    <a href="#"><span>Visualization</span></a>
                </div>
                <div class="p-5">
                    <span>{{ __('home.visualization') }}</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
