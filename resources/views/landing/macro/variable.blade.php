@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px]  h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Variable Used</h1>
        <p class="mb-5">Islamic Bankin Variable adalah data yang diambil dari Otortias Jasa Keuangan (OJK). Variabel yang di gunakan sistem informasi penilaian perbankan (SIPP) ada 4 variabel yaitu: (NFT), (CAR), (IPR), (FDR).</p>

        <div class="overflow-auto w-full flex flex-row text-left text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th class="py-4 px-4 text-center">NO</th>
                        <th class="py-4 px-4">Variable</th>
                        <th class="py-4 px-4">Explanation</th>
                        <th class="py-4 px-4">Form</th>
                        <th class="py-4 px-4">LINK</th>
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
                    "no": "A",
                    "var": "Gross Domestic Product (GDP)",
                    "exp": "Real GDP at Constant Price",
                    "form": "%",
                    "link": "https://www.bps.go.id/indicator/169/108/1/-2010-version-growth-rate-by-expenditure.html",
                },
                {
                    "no": "B",
                    "var": "Inflation (INF)",
                    "exp": "Real GDP at Constant Price",
                    "form": "%",
                    "link": "https://www.bps.go.id/indicator/169/108/1/-2010-version-growth-rate-by-expenditure.html",
                },
                {
                    "no": "C",
                    "var": "Exchange Rate (ER)",
                    "exp": "Real GDP at Constant Price",
                    "form": "%",
                    "link": "https://www.bps.go.id/indicator/169/108/1/-2010-version-growth-rate-by-expenditure.html",
                },
                {
                    "no": "D",
                    "var": "Stock Market Index (Jakarta Islamic Index) (JII)",
                    "exp": "Real GDP at Constant Price",
                    "form": "%",
                    "link": "https://www.bps.go.id/indicator/169/108/1/-2010-version-growth-rate-by-expenditure.html",
                },
            ]

            Object.keys(data).forEach((key, index) => {
                $('#tbody').append(`
                    <tr>
                        <td class="colspan-13 p-2"></td>
                    </tr>
                    <tr class="bg-ld-green/10">
                        <td class="py-2 px-4 text-center">${data[key].no}</td>
                        <td class="py-2 px-4">${data[key].var}</td>
                        <td class="py-2 px-4">${data[key].exp}</td>
                        <td class="py-2 px-4">${data[key].form}</td>
                        <td class="py-2 px-4">${data[key].link}</td>
                    </tr>
                `)
            })
        })
    </script>
@endpush
