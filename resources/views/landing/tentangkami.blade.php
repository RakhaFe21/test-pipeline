@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px]  h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Informasi Penilaian Perbankan Indonesia</h1>
        <p>Sistem Informasi Penilaian Perbankan Indonesia (SIP) adalah lembaga keuangan negara Indonesia yang terdapat suatu penilaian atau ukuran perbankaan saat ini dalam kondisi baik atau buruk. Dalam penilaian ini, kami meberikan informasi berupa data yang di peroleh dari Otoritas jasa Keuangan (OJK). data yang kami sajikan berupa Banking, Macroeconomic dan Integrasi Bank & Macro.</p>
        <p>. Penilaian kondisi perbankan dilakukan dengan pendekatan signal yang komprehensif dengan melibatkan indikator utama makroekonomi dan  faktor internal perbankan. SIPP mampu menilai kondisi perbankan setiap bulannya dengan menempatkan kinerja perbankan dalam 4 kategori yaitu optimal, toleran, rentan, dan stagnan. SIPP juga mampu memberikan rekomendasi terkait berapa kinerja perbankan yang seharusnya di capai oleh perbankan sehingga perbankan selalu dalam kondisi yang tahan dari berbagai goncangan internal dan eksternal.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-4 w-full gap-4 p-4 bg-ld-white rounded-lg mt-[50px] text-center">
            <div class="flex flex-row w-full gap-2 justify-center md:border-r-2 md:border-gray-200">
                <div class="flex flex-col items-center gap-2 p-4">
                    <div class="h-[50px]">
                        <img src="{{ asset('img/logo-ojk.png') }}" alt="" class="">
                    </div>
                    <div>
                        <p class="font-medium">Kunjungi website OJK</p>
                        <a href="https://www.ojk.go.id" class="text-blue-500">https://www.ojk.go.id</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-row w-full gap-2 justify-center md:border-r-2 md:border-gray-200">
                <div class="flex flex-col items-center gap-2 p-4">
                    <div class="h-[50px]">
                        <img src="{{ asset('img/logo-bi.png') }}" alt="" class="">
                    </div>
                    <div>
                        <p class="font-medium">Kunjungi website Bank Indonesia</p>
                        <a href="https://www.bi.go.id" class="text-blue-500">https://www.bi.go.id</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-row w-full gap-2 justify-center md:border-r-2 md:border-gray-200">
                <div class="flex flex-col items-center gap-2 p-4">
                    <div class="h-[50px]">
                        <img src="{{ asset('img/logo-btpn.png') }}" alt="" class="">
                    </div>
                    <div>
                        <p class="font-medium">Kunjungi website Bank BTPN</p>
                        <a href="https://www.btpn.com" class="text-blue-500">https://www.btpn.com</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-row w-full gap-2 justify-center">
                <div class="flex flex-col items-center gap-2 p-4">
                    <div class="h-[50px]">
                        <img src="{{ asset('img/logo-bca.png') }}" alt="" class="">
                    </div>
                    <div>
                        <p class="font-medium">Kunjungi website Bank BCA</p>
                        <a href="https://www.klikbca.com" class="text-blue-500">https://www.klikbca.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        })
    </script>
@endpush
