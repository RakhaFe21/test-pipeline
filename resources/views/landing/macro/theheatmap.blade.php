@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px] h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Setting the Heat Map</h1>
        <p class="mb-5">Data yang kami tampilkan berupa kondisi perbankan apakah dalam keadaan sehat atau tidak. Data yang kami tampilkan mulai tahun 2010 dari bulan Januari sampai Desember hingga saat ini.</p>

        <select id="selectYears" class="bg-gray-50 mb-4 border border-ld-green/50 text-gray-900 text-sm rounded-lg focus:ring-ld-green/50 focus:border-ld-green/50 block w-[100px] p-2.5"></select>

        <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th class="p-4">MONTH</th>
                        <th class="p-4">Jan</th>
                        <th class="p-4">Feb</th>
                        <th class="p-4">Mar</th>
                        <th class="p-4">Apr</th>
                        <th class="p-4">Mei</th>
                        <th class="p-4">Jun</th>
                        <th class="p-4">Jul</th>
                        <th class="p-4">Agu</th>
                        <th class="p-4">Sep</th>
                        <th class="p-4">Okt</th>
                        <th class="p-4">Nov</th>
                        <th class="p-4">Nov</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const data = [{
                    "var": "GDP",
                    "jan": "12.04",
                    "feb": "12.04",
                    "mar": "12.04",
                    "apr": "12.04",
                    "mei": "12.04",
                    "jun": "12.04",
                    "jul": "12.04",
                    "agu": "12.04",
                    "sep": "12.04",
                    "okt": "12.04",
                    "nov": "12.04",
                    "des": "12.04",
                },
                {
                    "var": "INF",
                    "jan": "12.04",
                    "feb": "12.04",
                    "mar": "12.04",
                    "apr": "12.04",
                    "mei": "12.04",
                    "jun": "12.04",
                    "jul": "12.04",
                    "agu": "12.04",
                    "sep": "12.04",
                    "okt": "12.04",
                    "nov": "12.04",
                    "des": "12.04",
                },
                {
                    "var": "ER",
                    "jan": "12.04",
                    "feb": "12.04",
                    "mar": "12.04",
                    "apr": "12.04",
                    "mei": "12.04",
                    "jun": "12.04",
                    "jul": "12.04",
                    "agu": "12.04",
                    "sep": "12.04",
                    "okt": "12.04",
                    "nov": "12.04",
                    "des": "12.04",
                },
                {
                    "var": "JII",
                    "jan": "12.04",
                    "feb": "12.04",
                    "mar": "12.04",
                    "apr": "12.04",
                    "mei": "12.04",
                    "jun": "12.04",
                    "jul": "12.04",
                    "agu": "12.04",
                    "sep": "12.04",
                    "okt": "12.04",
                    "nov": "12.04",
                    "des": "12.04",
                },
                {
                    "var": "MCI",
                    "jan": "12.04",
                    "feb": "12.04",
                    "mar": "12.04",
                    "apr": "12.04",
                    "mei": "12.04",
                    "jun": "12.04",
                    "jul": "12.04",
                    "agu": "12.04",
                    "sep": "12.04",
                    "okt": "12.04",
                    "nov": "12.04",
                    "des": "12.04",
                },
            ]

            Object.keys(data).forEach((key, index) => {
                $('#tbody').append(`
                    <tr>
                        <td class="colspan-13 p-2"></td>
                    </tr>
                    <tr class="bg-ld-green/10">
                        <td class="p-2">${data[key].var}</td>
                        <td class="p-2">${data[key].jan}</td>
                        <td class="p-2">${data[key].feb}</td>
                        <td class="p-2">${data[key].mar}</td>
                        <td class="p-2">${data[key].apr}</td>
                        <td class="p-2">${data[key].mei}</td>
                        <td class="p-2">${data[key].jun}</td>
                        <td class="p-2">${data[key].jul}</td>
                        <td class="p-2">${data[key].agu}</td>
                        <td class="p-2">${data[key].sep}</td>
                        <td class="p-2">${data[key].okt}</td>
                        <td class="p-2">${data[key].nov}</td>
                        <td class="p-2">${data[key].des}</td>
                    </tr>
                `)
            })

            const years = ['2010', '2011', '2012', '2013', '2014', '2015']

            years.forEach(function(value, index) {
                $('#selectYears').append(`
                    <option value='${value}'>${value}</option>
                `)
            })

        })
    </script>
@endpush
