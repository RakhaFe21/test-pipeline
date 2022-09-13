@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px]  h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Variable Used</h1>
        <p class="mb-5">Islamic Bankin Variable adalah data yang diambil dari Otortias Jasa Keuangan (OJK). Variabel yang di gunakan sistem informasi penilaian perbankan (SIPP) ada 4 variabel yaitu: (NPF), (CAR), (IPR), (FDR).</p>

        <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th class="p-4">NO</th>
                        <th class="p-4">
                            <p class="flex flex-col"><span>Islamic Banking Variables</span><span>Otoritas Jasa Keuangan/OJK</span></p>
                        </th>
                        <th class="p-4">FORM</th>
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

            const bankVariable = [{
                    "no": "A",
                    "data": "Non-performing financing (NPF)",
                    "value": "%"
                },
                {
                    "no": "B",
                    "data": "Capital Adequacy Ratio (CAR)",
                    "value": "%"
                },
                {
                    "no": "C",
                    "data": "Investment Proportion and Risk (IPR)",
                    "value": "%"
                },
                {
                    "no": "D",
                    "data": "Financings to Deposits Ratio (FDR)",
                    "value": "%"
                },
            ]

            Object.keys(bankVariable).forEach((key, index) => {
                $('#tbody').append(`
                    <tr>
                        <td class="colspan-13 p-2"></td>
                    </tr>
                    <tr class="bg-ld-green/10">
                        <td class="p-2">${bankVariable[key].no}</td>
                        <td class="p-2">${bankVariable[key].data}</td>
                        <td class="p-2">${bankVariable[key].value}</td>
                    </tr>
                `)
            })
        })
    </script>
@endpush
