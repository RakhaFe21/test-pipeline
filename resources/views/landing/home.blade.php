@extends('template.landing')

@section('content')
    @include('partial.header')

    <section class="container mx-auto py-[50px]">
        <div class="px-4">
            <div class="flex flex-col items-center content-center text-center">
                <span class="font-medium text-[30px] text-ld-green">Pahami Data Kami</span>
                <span class="font-medium text-[18px] text-ld-red">Sistem Penilaian Perbankan Indonesia</span>
                <span class="text-[18px] max-w-[500px]">Perhitungan Banking, Macroeconomic dan Integrasi (Bank & Macro) merupakan cara kami untuk menilai perbankan saat ini. Kami mengabil sampel informasi di setiap data</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-[50px]">
                <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                        <a href="#"><span>Variable</span></a>
                    </div>
                    <div class="p-5">
                        <span>Urutan dari Variable Indonesia Banking (NPF, CAR, IPR dan FDR). Sedangkan Urutan dari Variable Indonesia Macro Yaitu (GDP, INF, ER, JII). Kedua Variable antara Bankin & Macro akan berintegrasi</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                        <a href="#"><span>Data</span></a>
                    </div>
                    <div class="p-5">
                        <span>Data variable akan diupdate setiap bulan satu sampai dua belas. Jadi kemungkinan besar data variable bisa saja naik ataupun turun perbulannya</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                        <a href="#"><span>Theoritical Framework</span></a>
                    </div>
                    <div class="p-5">
                        <span>Kerangkan teori SIP. Membangun Indeks ketahanan Perbankan syariah dan membangun indeks kerentanan ekonomi Makro</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                        <a href="#"><span>The Heat Map</span></a>
                    </div>
                    <div class="p-5">
                        <span>Melihat ketahanan data variable di setiap bulannya dengan memberikan petunjuk warna apakah sehat, cukup, rentang atau ketat.</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5 bg-ld-green text-white-1 rounded-t-lg text-center text-[22px]">
                        <a href="#"><span>Visualization</span></a>
                    </div>
                    <div class="p-5">
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nisl amet dignissim purus vestibulum ac suscipit imperdiet quisque vulputate. Egestas neque adipiscing lorem non praesent faucibus. Blandit ornare dui vestibulum mauris nec.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nisl amet dignissim purus vestibulum ac suscipit imperdiet quisque vulputate. Egestas neque adipiscing lorem non praesent faucibus. Blandit ornare dui vestibulum mauris nec.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
