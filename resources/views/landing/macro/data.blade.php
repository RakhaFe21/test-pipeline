@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px] h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Data</h1>
        <p class="mb-5">Menampilkan data setiap bulan dari sebuah variabel. Data berupa angka yang di tampilkan berbeda setiap bulannya, mulai dari angka yang paling rendah maupun angka yang paling tinggi. Data yang kami kumpulkan mulai tahun 2010 hingga saat ini.</p>

        <select id="selectYears" class="bg-gray-50 border border-ld-green/50 mb-4 text-gray-900 text-sm rounded-lg focus:ring-ld-green/50 focus:border-ld-green/50 block w-[100px] p-2.5"></select>

        <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th class="p-4">MONTH</th>
                        <th class="p-4">GDP (Interpolasi Sum)</th>
                        <th class="p-4">INFLASI</th>
                        <th class="p-4">EXCHANGE RATE</th>
                        <th class="p-4">Jakarta Islamic Index (JII)</th>
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
                    "month": "JANUARI",
                    "npf": "4,36",
                    "car": "11,26",
                    "ipr": "35,89",
                    "fdr": "35,89",
                },
                {
                    "month": "FEBRUARI",
                    "npf": "4,36",
                    "car": "11,26",
                    "ipr": "35,89",
                    "fdr": "35,89",
                },
                {
                    "month": "MARET",
                    "npf": "4,36",
                    "car": "11,26",
                    "ipr": "35,89",
                    "fdr": "35,89",
                },
                {
                    "month": "APRIL",
                    "npf": "4,36",
                    "car": "11,26",
                    "ipr": "35,89",
                    "fdr": "35,89",
                },
            ]

            Object.keys(data).forEach((key, index) => {
                $('#tbody').append(`
                    <tr>
                        <td class="colspan-13 p-2"></td>
                    </tr>
                    <tr class="bg-ld-green/10">
                        <td class="p-2">${data[key].month}</td>
                        <td class="p-2">${data[key].npf}</td>
                        <td class="p-2">${data[key].car}</td>
                        <td class="p-2">${data[key].ipr}</td>
                        <td class="p-2">${data[key].fdr}</td>
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
