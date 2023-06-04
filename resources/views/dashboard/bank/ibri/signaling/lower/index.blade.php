@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Lower Threshold</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Macro, Data, Signaling Threshold, Lower Threshold</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <select
                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[50px] p-3.5" id="selectPeriod">
            </select>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4">
            <table class="w-full text-sm text-left text-center" id="upperTreshold">
                <thead class="text-xs uppercase bg-gray-200" id="headerUpper">

                </thead>
                <tbody id="tbodyUpper">

                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center" id="upperTresholdSummary">
                <thead class="text-xs uppercase bg-gray-200" id="upperTresholdHeader">

                </thead>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const tahun = {!! json_encode($tahun) !!}

            Object.keys(tahun).forEach((key, value) => {
                $('#selectPeriod').append(`
                    <option value="${tahun[key].tahun}-${tahun[key].variable_masters_id}-${tahun[key].nama_variable.toUpperCase()}">${tahun[key].tahun} - ${tahun[key].nama_variable.toUpperCase()}</option>
                `)
            })

            /*
            * Get upper treshold data
            * */
            let period = $('#selectPeriod').val()
            let splitPeriode = period.split('-');

            getData(period, splitPeriode[2])

            $('#selectPeriod').on('change', function () {
                getData($(this).val(), splitPeriode[2])
            })

            /**
             * Get Months
             */
            function months(month) {
                const date = new Date()
                date.setMonth(month - 1)

                return date.toLocaleString('{{ config('app.locale') }}', {
                    month: 'long',
                })
            }

            async function getData(period) {
                $('#tbodyUpper').html('')
                await axios.get('{{ route('dashboard.bank.ibri.signaling.lower.data') }}?periode='+period).then(resp => {

                    let varData = resp.data.data
                    let avg = resp.data.average
                    let mean = resp.data.averageSignaling
                    let stdev = resp.data.stdev
                    let varName = resp.data.varName === "CI" ? 'CI' : 'I'+resp.data.varName
                    let signal = resp.data.signal

                    /* Get total signal */
                    let signalTotal = 0
                    Object.keys(signal).forEach((key, index) => {
                        let calcSignal = (signal[key].value_index < avg)?1:0
                        signalTotal += calcSignal
                    })

                    /* Render header */
                    $('#headerUpper').html('')
                    $('#headerUpper').html(`
                        <tr>
                            <th scope="col" class="py-3 px-6">YEAR</th>
                            <th scope="col" class="py-3 px-6">MONTHS</th>
                            <th scope="col" class="py-3 px-6">`+varName+`</th>
                            <th scope="col" class="py-3 px-6">AVERAGE</th>
                            <th scope="col" class="py-3 px-6">SIGNAL</th>
                        <tr>
                    `)

                    /* Render data */
                    let totalSignal = 0
                    Object.keys(varData).forEach((key, index) => {
                        let first = true
                        let rowSpaned = ''
                        let signal = (varData[key].value_index < avg)?1:0
                        totalSignal += parseInt(signal)

                        if(index==0) {
                            rowSpaned = `<td rowspan="12" class="border border-slate-300 py-4 px-6">${varData[key].tahun}</td>`
                        } else {
                            rowSpaned = ''
                        }

                        $('#tbodyUpper').append(`
                            <tr>`+rowSpaned+`<td class="border border-slate-300 py-4 px-6">`+months(varData[key].bulan)+`</td>
                                <td class="border border-slate-300 py-4 px-6">${varData[key].value_index.toFixed(2)}</td>
                                <td class="border border-slate-300 py-4 px-6">${avg}</td>
                                <td class="border border-slate-300 py-4 px-6">${signal}</td>
                            </tr>
                        `)
                    })

                    $('#upperTresholdHeader').html(`
                        <tr>
                            <th scope="col" class="py-3 px-6">STEDEV</th>
                            <th scope="col" class="py-3 px-6">${stdev}</th>
                            <th scope="col" class="py-3 px-6">MEAN</th>
                            <th scope="col" class="py-3 px-6">${mean}</th>
                            <th scope="col" class="py-3 px-6">TOTAL SIGNAL</th>
                            <th scope="col" class="py-3 px-6">${signalTotal}</th>
                        <tr>
                    `)

                })
            }

        })
    </script>
@endpush
