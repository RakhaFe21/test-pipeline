@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Signaling</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Integrasi Bank & Macro, Signaling, Upper Treshold</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <select
                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[50px] p-3.5" id="selectPeriod">
            </select>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap text-sm font-medium text-center" id="tab" data-tabs-toggle="#tabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="table-tab" data-tabs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">MVI</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="ibri-tab" data-tabs-target="#ibri" type="button" role="tab" aria-controls="ibri" aria-selected="false">IBRI</button>
                </li>
            </ul>
        </div>
        <div id="tabContent">
            <div class="hidden" id="table" role="tabpanel" aria-labelledby="table-tab">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4">
                    <table class="w-full text-sm text-left text-center">
                        <thead class="text-xs uppercase bg-gray-200">
                            <tr>
                                <th scope="col" rowspan="2" class="py-3 px-6">Month</th>
                                <th scope="col" rowspan="2" class="py-3 px-6">Macroeconomic Vulnerability Index <br>MVI</th>
                                <th scope="col" colspan="2" class="py-3 px-6">Treshold(Tr)</th>
                            </tr>
                            <tr>
                                <th scope="col" class="py-3 px-6">Average</th>
                                <th scope="col" class="py-3 px-6">Signal</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>

                </div>
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-center" id="upperTresholdSummaryMvi">
                        <thead class="text-xs uppercase bg-gray-200" id="upperTresholdHeaderMvi">
        
                        </thead>
                    </table>
                </div>
            </div>
            <div class="hidden" id="ibri" role="tabpanel" aria-labelledby="ibri-tab">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" rowspan="2" class="py-3 px-6">Month</th>
                            <th scope="col" rowspan="2" class="py-3 px-6">Islamic Banking Resilience Index <br>IBRI</th>
                            <th scope="col" colspan="2" class="py-3 px-6">Treshold(Tr)</th>
                        </tr>
                        <tr>
                            <th scope="col" class="py-3 px-6">Average</th>
                            <th scope="col" class="py-3 px-6">Signal</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-ibri">

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const tabElements = [{
                    id: 'MVI',
                    triggerEl: document.querySelector('#table-tab'),
                    targetEl: document.querySelector('#table')
                },
                {
                    id: 'IBRI',
                    triggerEl: document.querySelector('#ibri-tab'),
                    targetEl: document.querySelector('#ibri')
                }
            ];

            const options = {
                defaultTabId: 'settings',
                activeClasses: 'text-ds-blue hover:text-ds-blue border-ds-blue',
                inactiveClasses: 'text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300',
                onShow: () => {}
            }

            const tabs = new Tabs(tabElements, options)
            tabs.show('MVI')
            tabs.getTab('IBRI')

            const tahun = {!! json_encode($tahun) !!}

            Object.keys(tahun).forEach((key, value) => {
                $('#selectPeriod').append(`
                    <option value="${tahun[key].tahun}}">${tahun[key].tahun}</option>
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

                return date.toLocaleString('en', {
                    month: 'long',
                })
            }

            async function getData(period) {
                $('#tbody').html('')
                $('#tbody-ibri').html('')
                $('#upperTresholdHeaderMvi').html('')
                await axios.get('{{ route('dashboard.integrasi.signaling.upper.data' , ['code'  => \Route::current()->parameter('code') ]) }}?periode='+period).then(resp => {

                    // MVI
                    let varDataMvi = resp.data.data[0].data
                    let avgMvi = resp.data.data[0].average
                    let meanMvi = resp.data.data[0].averageSignaling
                    let stdevMvi = resp.data.data[0].stdev
                    let varNameMvi = resp.data.data[0].varName === "CI" ? 'CI' : 'I'+resp.data.data[0].varName
                    let signalMvi = resp.data.data[0].signal

                    /* Get total signal */
                    let signalTotalMvi = 0
                    Object.keys(varDataMvi).forEach((key, index) => {
                        let calcSignalMvi = (varDataMvi[key].value_index > avgMvi)?1:0
                        signalTotalMvi += calcSignalMvi
                    })

                    /* Render data */
                    let totalSignalMvi = 0
                    Object.keys(varDataMvi).forEach((key, index) => {
                        let signal = (varDataMvi[key].value_index > avgMvi)?1:0
                       $('#tbody').append(`
                            <tr><td class="border border-slate-300 py-4 px-6">`+months(varDataMvi[key].bulan)+`</td>
                                <td class="border border-slate-300 py-4 px-6">${varDataMvi[key].value_index.toFixed(2)}</td>
                                <td class="border border-slate-300 py-4 px-6">${avgMvi}</td>
                                <td class="border border-slate-300 py-4 px-6">${signal}</td>
                            </tr>
                       `);
                    })

                    $('#upperTresholdHeaderMvi').html(`
                        <tr>
                            <th scope="col" class="py-3 px-6">STEDEV</th>
                            <th scope="col" class="py-3 px-6">${stdevMvi}</th>
                            <th scope="col" class="py-3 px-6">MEAN</th>
                            <th scope="col" class="py-3 px-6">${meanMvi}</th>
                            <th scope="col" class="py-3 px-6">TOTAL SIGNAL</th>
                            <th scope="col" class="py-3 px-6">${signalTotalMvi}</th>
                        <tr>
                    `)

                    // BANKING
                    let varDataBanking = resp.data.data[1].data
                    let avgBanking = resp.data.data[1].average
                    let meanBanking = resp.data.data[1].averageSignaling
                    let stdevBanking = resp.data.data[1].stdev
                    let varNameBanking = resp.data.data[1].varName === "CI" ? 'CI' : 'I'+resp.data.data[1].varName
                    let signalBanking = resp.data.data[1].signal

                    /* Get total signal */
                    let signalTotalBanking = 0
                    Object.keys(signalBanking).forEach((key, index) => {
                        let calcSignalBanking = (signalBanking[key].value_index > avgBanking)?1:0
                        signalTotalBanking += calcSignalBanking
                    })

                    /* Render data */
                    let totalSignalBanking = 0
                    Object.keys(varDataBanking).forEach((key, index) => {
                        let signal = (varDataBanking[key].value_index > avgBanking)?1:0
                       $('#tbody-ibri').append(`
                            <tr><td class="border border-slate-300 py-4 px-6">`+months(varDataBanking[key].bulan)+`</td>
                                <td class="border border-slate-300 py-4 px-6">${varDataBanking[key].value_index.toFixed(2)}</td>
                                <td class="border border-slate-300 py-4 px-6">${avgBanking}</td>
                                <td class="border border-slate-300 py-4 px-6">${signal}</td>
                            </tr>
                       `);
                    })
                })
            }
        })
    </script>
@endpush
