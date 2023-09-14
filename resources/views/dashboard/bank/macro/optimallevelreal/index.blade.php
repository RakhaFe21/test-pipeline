@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Optimal Level In Real</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Macro, Data, Optimal Level In Real</span>
            </div>
        </div>

        <div class="box-border h-32 w-32 p-4 border-4 bg-gray-100 rounded-lg mb-4">
            <div class="inline-block flex">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="variable">
                        Variable
                    </label>
                    <select
                        class="bg-gray-50 flex w-full border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray p-3.5 mr-4" id="selectVariable">
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2 ml-4" for="tahun">
                        Tahun
                    </label>
                    <select
                        class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray flex w-full w-[100px] p-3.5 ml-4" id="selectYear">
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap text-sm font-medium text-center" id="tab" data-tabs-toggle="#tabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="table-tab" data-tabs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">Table</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="chart-tab" data-tabs-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="false">Grafis</button>
                </li>
            </ul>
        </div>
        <div id="tabContent">
            <div class="hidden" id="table" role="tabpanel" aria-labelledby="table-tab">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-center">
                        <thead class="text-xs uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">Months</th>
                                <th scope="col" class="py-3 px-6" id="variableName-column">Variable</th>
                                <th scope="col" class="py-3 px-6">Upper TH <br> <span class="upper-label"></span> Month</th>
                                <th scope="col" class="py-3 px-6">Average Total</th>
                                <th scope="col" class="py-3 px-6">Lower TH <br> <span class="upper-label-low"></span> Month</th>
                                <th scope="col" class="py-3 px-6">Description</th>
                            </tr>
                        </thead>
                        <tbody id="tbody" class="skalz-tbody">

                        </tbody>
                    </table>
                </div>
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5 p-5">
                    <table class="w-full text-sm text-right" style="border-collapse: separate; border-spacing:0 30px">
                        <thead class="text-xs uppercase">
                            <tr>
                                <th scope="col" class=""><span class="upper-label"></span> Month</th>
                                <th scope="col" class=""></th>
                                <th scope="col" class=""></th>
                                <th scope="col" class=""><span class="upper-label-low"></span> Month</th>
                                <th scope="col" class=""></th>
                                <th scope="col" class=""></th>
                                <th scope="col" class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6">STDEV</td>
                                <td class="py-4 px-6  border border-slate-300 bg-gray-100 addData" id="stdevCol"></td>
                                <td class="py-4 px-6"></td>
                                <td class="py-4 px-6">STDEV</td>
                                <td class="py-4 px-6 border border-slate-300 bg-gray-100 addData" id="stdevColLow"></td>
                                <td class="py-4 px-6"></td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 mt-5">
                                <td class="py-4 px-6">MEAN</td>
                                <td class="py-4 px-6  border border-slate-300 bg-gray-100 addData" id="meanCol"></td>
                                <td class="py-4 px-6"></td>
                                <td class="py-4 px-6">MEAN</td>
                                <td class="py-4 px-6 border border-slate-300 bg-gray-100 addData" id="meanColLow"></td>
                                <td class="py-4 px-6"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden flex flex-row items-center justify-center pt-10" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                
                    <canvas id="chart-section" width="100%" height="50%"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script>
        $(document).ready(function() {

            const tahun = {!! json_encode($tahun) !!}
            const variable = {!! json_encode($variable) !!}
            const averageGlobal = {{ $avg}}
            let bulan = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

            // Object.keys(tahun).forEach((key, index) => {
            //     $('#tbody').append(`
            //         <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            //             <td class="py-4 px-6">${tahun[key].tahun}</td>
            //             <td class="py-4 px-6">${tahun[key].id}</td>
            //             <td class="py-4 px-6">${tahun[key].id}</td>
            //             <td class="py-4 px-6">${tahun[key].id}</td>
            //             <td class="py-4 px-6">${tahun[key].id}</td>
            //             <td class="py-4 px-6">${tahun[key].id}</td>
            //         </tr>
            //     `)
            // })

            Object.keys(variable).forEach((key, index) => {
                $('#selectVariable').append(`<option value="${variable[key].id}">${variable[key].nama_variable.toUpperCase()}</option>`)
            })

            Object.keys(tahun).forEach((key, index) => {
                $('#selectYear').append(`<option value="${tahun[key].tahun}">${tahun[key].tahun}</option>`)
            })

            $('#selectVariable').on('change', function () {
                $('.skalz-tbody').html('')
                $('.addData').html('')
                $("#chart-section").remove();
                $("#chart").append('<canvas id="chart-section"></canvas>');

                renderTable()
            })

            $('#selectYear').on('change', function () {
                $('.skalz-tbody').html('')
                $('.addData').html('')
                $("#chart-section").remove();
                $("#chart").append('<canvas id="chart-section"></canvas>');

                renderTable()
            })

            const tabElements = [{
                    id: 'table',
                    triggerEl: document.querySelector('#table-tab'),
                    targetEl: document.querySelector('#table')
                },
                {
                    id: 'chart',
                    triggerEl: document.querySelector('#chart-tab'),
                    targetEl: document.querySelector('#chart')
                }
            ];

            const options = {
                defaultTabId: 'settings',
                activeClasses: 'text-ds-blue hover:text-ds-blue border-ds-blue',
                inactiveClasses: 'text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300',
                onShow: () => {}
            }

            const tabs = new Tabs(tabElements, options)
            tabs.show('table')
            tabs.getTab('chart')

            renderTable()

            async function renderTable() {
                let year = $('#selectYear').val()
                let signal = await reqSignal()
                let dataVar = await reqDataVar()
                let signalLow = await reqSignalLow()
                let resultHorizon = await convertHorizon(signal)
                let resultHorizonLow = await convertHorizon(signalLow)
                let resultFilter = await filterRangkumanMonthnByYear(resultHorizon);
                let resultFilterLow = await filterRangkumanMonthnByYear(resultHorizonLow);
                let lowGsb = await getLowGsb(resultFilter)
                let lowGsbLow = await getLowGsb(resultFilterLow)
                let stDev = await getStdev(dataVar, lowGsb)
                let stDevLow = await getStdev(dataVar, lowGsbLow)
                let meanTotal = await getMeanTotal(dataVar);
                let mean = await getMean(dataVar, lowGsb);
                let meanLow = await getMean(dataVar, lowGsbLow);
                let listByYear = await filterByYear(dataVar, year)
                renderData(listByYear, stDev, mean, meanTotal, lowGsb, stDevLow, meanLow, lowGsbLow)
                
            }

            async function reqDataVar() {
                try {
                    const fVariable = $('#selectVariable').val()
                    const fTahun = $('#selectYear').val()
                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.macro.optimallevelreal.data' , ['code' => \Route::current()->parameter('code')]) }}',
                        headers: {},
                        params: {
                            'variable': fVariable
                        }
                    })

                    const data = signal.data

                    if(data.code === 200) {
                        console.log(data.data);
                        return data.data
                    } else {
                        console.log(data.message);
                        toastr.error(data.message)
                    }

                } catch (error) {
                    toastr.error(error.message)
                }
            }

            async function reqSignal() {
                try {
                    const fVariable = $('#selectVariable').val()
                    const fTahun = $('#selectYear').val()
                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.macro.ews.signal' , ['code' => \Route::current()->parameter('code')]) }}',
                        headers: {},
                        params: {
                            'variable': fVariable
                        }
                    })

                    const data = signal.data

                    if(data.code === 200) {
                        console.log(data.data);
                        return data.data
                    } else {
                        console.log(data.message);
                        toastr.error(data.message)
                    }

                } catch (error) {
                    toastr.error(error.message)
                }
            }

            async function reqSignalLow() {
                try {
                    const fVariable = $('#selectVariable').val()
                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.macro.ews.signal-lower' , ['code' => \Route::current()->parameter('code')]) }}',
                        headers: {},
                        params: {
                            'variable': fVariable
                        }
                    })

                    const data = signal.data

                    if(data.code === 200) {
                        console.log(data.data);
                        return data.data
                    } else {
                        console.log(data.message);
                        toastr.error(data.message)
                    }

                } catch (error) {
                    toastr.error(error.message)
                }
            }

            async function filterByYear(data, year){
                let result = []
                data.forEach(el => {
                    if (el.tahun == year) {
                        result.push(el)
                    }
                })

                return result
            }

            async function renderData(datas, stdev, mean, meanTotal, limit, stDevLow, meanLow, limitLow){
                $('#stdevCol').html(stdev.toFixed(4))
                $('#meanCol').html(mean.toFixed(4))
                $('#stdevColLow').html(stDevLow.toFixed(4))
                $('#meanColLow').html(meanLow.toFixed(4))
                let upper = mean + (averageGlobal * stdev)
                let lower = meanLow - (averageGlobal * stDevLow)
                var desc
                var var_id = $('#selectVariable').val()
                $('.upper-label').html(`${limit}`)
                $('.upper-label-low').html(`${limitLow}`)
                let prepChart = {
                    name: $('#selectVariable option:selected' ).text(),
                    month:[],
                    value_index:[],
                    upperTh : {
                        name: 'Upper Treshold',
                        data: []
                    },
                    lowerTh:{
                        name: 'Lower Treshold',
                        data: []
                    },
                    average:{
                        name: 'Average Total',
                        data:[]
                    }
                };
                datas.forEach(data => {
                    desc = getDescription(data.value, upper, meanTotal, lower, var_id);
                    prepChart.value_index.push(parseFloat(data.value.toFixed(2)))
                    prepChart.upperTh.data.push(parseFloat(upper.toFixed(2)))
                    prepChart.lowerTh.data.push(parseFloat(lower.toFixed(2)))
                    prepChart.average.data.push(parseFloat(meanTotal.toFixed(2)))
                    prepChart.month.push(bulan[data.bulan - 1])
                    $('.skalz-tbody').append(`
                        <tr>
                            <td class="border border-slate-300 py-4 px-6">${bulan[data.bulan - 1]}</td>
                            <td class="border border-slate-300 py-4 px-6">${data.value.toFixed(2)}</td>
                            <td class="border border-slate-300 py-4 px-6">${upper.toFixed(2)}</td>
                            <td class="border border-slate-300 py-4 px-6">${meanTotal.toFixed(2)}</td>
                            <td class="border border-slate-300 py-4 px-6">${lower.toFixed(2)}</td>
                            <td class="border border-slate-300 py-4 px-6">${desc}</td>
                        </tr>
                    `)
                });
                generateChart(prepChart)
            }

            async function getStdev(datas, index){
                let result = []
                for (let i = 0; i < datas.length; i++) {
                    if (i > (index-1)) {
                        result.push(datas[i].value)
                    }
                    
                }
                return getStandardDeviation(result)
            }

            async function getMean(datas, index){
                let result = []
                for (let i = 0; i < datas.length; i++) {
                    if (i > (index-1)) {
                        result.push(datas[i].value)
                    }
                    
                }
                return avg(result)
            }

            async function getMeanTotal(datas){
                let result = []
                datas.forEach((el, index) => {
                    result.push(el.value)                    
                })
                return avg(result)
            }

            async function getStandardDeviation (array) {
                const signal = await axios({
                    method: 'get',
                    url: "{{ route('dashboard.stdev' , ['code' => \Route::current()->parameter('code')]) }}",
                    headers: {},
                    params: {
                        'array': array
                    }
                })

                return signal.data
            }

            function avg(array) {
                var total = array.reduce((acc, c) => acc + c, 0);
                return total / array.length;
            }

            function getDescription(value, upper, average, lower, var_id) {
                if (var_id == 1) {
                    return npfDesc(value, upper, average, lower)
                } else if (var_id == 2) {
                    return carDesc(value, upper, average, lower)
                } else if (var_id == 3) {
                    return iprDesc(value, upper, average, lower)
                } else if (var_id == 4) {
                    return fdrDesc(value, upper, average, lower)
                } else {
                    return ciDesc(value, upper, average, lower)
                }
                
            }

            function npfDesc(value, upper, average, lower) {
                if (value > upper) {
                    return 'Vunerabiity'
                } 

                if (value < lower) {
                    return 'Stagnant/Strict'
                } 

                if (value <= average && value >= lower) {
                    return 'Expected/Optimal'
                }

                if (value > average && value <= upper ) {
                    return 'Tolerance'
                }
            }

            function carDesc(value, upper, average, lower) {
                if (value > upper) {
                    return 'Stagnant/Strict'
                } 

                if (value < lower) {
                    return 'Vulnerability'
                } 

                if (value >= average && value <= upper) {
                    return 'Expected/Optimal'
                }

                if (value < average && value >= lower ) {
                    return 'Tolerance'
                }
            }

            function iprDesc(value, upper, average, lower) {
                if (value > upper) {
                    return 'Stagnant/Strict'
                } 

                if (value < lower) {
                    return 'Vulnerability'
                } 

                if (value >= average && value <= upper) {
                    return 'Expected/Optimal'
                }

                if (value < average && value >= lower ) {
                    return 'Tolerance'
                }
            }

            function fdrDesc(value, upper, average, lower) {
                if (value > upper) {
                    return 'Vunerabiity'
                } 

                if (value < lower) {
                    return 'Stagnant/Strict'
                } 

                if (value <= average && value >= lower) {
                    return 'Expected/Optimal'
                }

                if (value > average && value <= upper ) {
                    return 'Tolerance'
                }
            }

            function ciDesc(value, upper, average, lower) {
                if (value > upper) {
                    return 'Stagnant/Strict'
                } 

                if (value < lower) {
                    return 'Vulnerability'
                } 

                if (value >= average && value <= upper) {
                    return 'Expected/Optimal'
                }

                if (value < average && value > lower ) {
                    return 'Tolerance'
                }
            }

            async function convertHorizon(data) {
                let result = []
                for (let i = 0; i < data.length; i++) {
                    if (data[i].tahun === "2010") {
                        if (data[i].bulan == 1) {
                            data[i].month1 = null
                            data[i].month3 = null
                            data[i].month6 = null
                            data[i].month12 = null
                            data[i].month24 = null
                            data[i].nilaiMonth1_1 = null
                            data[i].nilaiMonth1_2 = null
                            data[i].nilaiMonth3_1 = null
                            data[i].nilaiMonth3_2 = null
                            data[i].nilaiMonth6_1 = null
                            data[i].nilaiMonth6_2 = null
                            data[i].nilaiMonth12_1 = null
                            data[i].nilaiMonth12_2 = null
                            data[i].nilaiMonth24_1 = null
                            data[i].nilaiMonth24_2 = null
                        } else if (data[i].bulan < 4){
                            data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                            data[i].month3 = null
                            data[i].month6 = null
                            data[i].month12 = null
                            data[i].month24 = null
                            data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                            data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                            data[i].nilaiMonth3_1 = null
                            data[i].nilaiMonth3_2 = null
                            data[i].nilaiMonth6_1 = null
                            data[i].nilaiMonth6_2 = null
                            data[i].nilaiMonth12_1 = null
                            data[i].nilaiMonth12_2 = null
                            data[i].nilaiMonth24_1 = null
                            data[i].nilaiMonth24_2 = null
                        } else if (data[i].bulan == 4){
                            data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                            data[i].month3 = getMonthValue(data[i-3].signal, data[i].signal_crisis)
                            data[i].month6 = null
                            data[i].month12 = null
                            data[i].month24 = null
                            data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                            data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                            data[i].nilaiMonth3_1 = getMonthResult(data[i-3].signal, data[i].signal_crisis)
                            data[i].nilaiMonth3_2 = data[i].nilaiMonth3_1 ** 2
                            data[i].nilaiMonth6_1 = null
                            data[i].nilaiMonth6_2 = null
                            data[i].nilaiMonth12_1 = null
                            data[i].nilaiMonth12_2 = null
                            data[i].nilaiMonth24_1 = null
                            data[i].nilaiMonth24_2 = null
                        } else if (data[i].bulan < 7){
                            data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                            data[i].month3 = getMonthValue(data[i-3].signal, data[i].signal_crisis)
                            data[i].month6 = null
                            data[i].month12 = null
                            data[i].month24 = null
                            data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                            data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                            data[i].nilaiMonth3_1 = getMonthResult(data[i-3].signal, data[i].signal_crisis)
                            data[i].nilaiMonth3_2 = data[i].nilaiMonth3_1 ** 2
                            data[i].nilaiMonth6_1 = null
                            data[i].nilaiMonth6_2 = null
                            data[i].nilaiMonth12_1 = null
                            data[i].nilaiMonth12_2 = null
                            data[i].nilaiMonth24_1 = null
                            data[i].nilaiMonth24_2 = null
                        } else if (data[i].bulan == 7){
                            data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                            data[i].month3 = getMonthValue(data[i-3].signal, data[i].signal_crisis)
                            data[i].month6 = getMonthValue(data[i-6].signal, data[i].signal_crisis)
                            data[i].month12 = null
                            data[i].month24 = null
                            data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                            data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                            data[i].nilaiMonth3_1 = getMonthResult(data[i-3].signal, data[i].signal_crisis)
                            data[i].nilaiMonth3_2 = data[i].nilaiMonth3_1 ** 2
                            data[i].nilaiMonth6_1 = getMonthResult(data[i-6].signal, data[i].signal_crisis)
                            data[i].nilaiMonth6_2 = data[i].nilaiMonth6_1 ** 2
                            data[i].nilaiMonth12_1 = null
                            data[i].nilaiMonth12_2 = null
                            data[i].nilaiMonth24_1 = null
                            data[i].nilaiMonth24_2 = null
                        }else if (data[i].bulan <  12){
                            data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                            data[i].month3 = getMonthValue(data[i-3].signal, data[i].signal_crisis)
                            data[i].month6 = getMonthValue(data[i-6].signal, data[i].signal_crisis)
                            data[i].month12 = null
                            data[i].month24 = null
                            data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                            data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                            data[i].nilaiMonth3_1 = getMonthResult(data[i-3].signal, data[i].signal_crisis)
                            data[i].nilaiMonth3_2 = data[i].nilaiMonth3_1 ** 2
                            data[i].nilaiMonth6_1 = getMonthResult(data[i-6].signal, data[i].signal_crisis)
                            data[i].nilaiMonth6_2 = data[i].nilaiMonth6_1 ** 2
                            data[i].nilaiMonth12_1 = null
                            data[i].nilaiMonth12_2 = null
                            data[i].nilaiMonth24_1 = null
                            data[i].nilaiMonth24_2 = null
                        }  else {
                            data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                            data[i].month3 = getMonthValue(data[i-3].signal, data[i].signal_crisis)
                            data[i].month6 = getMonthValue(data[i-6].signal, data[i].signal_crisis)
                            data[i].month12 = null
                            data[i].month24 = null
                            data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                            data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                            data[i].nilaiMonth3_1 = getMonthResult(data[i-3].signal, data[i].signal_crisis)
                            data[i].nilaiMonth3_2 = data[i].nilaiMonth3_1 ** 2
                            data[i].nilaiMonth6_1 = getMonthResult(data[i-6].signal, data[i].signal_crisis)
                            data[i].nilaiMonth6_2 = data[i].nilaiMonth6_1 ** 2
                            data[i].nilaiMonth12_1 = null
                            data[i].nilaiMonth12_2 = null
                            data[i].nilaiMonth24_1 = null
                            data[i].nilaiMonth24_2 = null
                        }
                        // data[i+1]
                        result[i] = data[i]
                    }

                    if (data[i].tahun === "2011") {
                        data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                        data[i].month3 = getMonthValue(data[i-3].signal, data[i].signal_crisis)
                        data[i].month6 = getMonthValue(data[i-6].signal, data[i].signal_crisis)
                        data[i].month12 = getMonthValue(data[i-12].signal, data[i].signal_crisis)
                        data[i].month24 = null
                        data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                        data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                        data[i].nilaiMonth3_1 = getMonthResult(data[i-3].signal, data[i].signal_crisis)
                        data[i].nilaiMonth3_2 = data[i].nilaiMonth3_1 ** 2
                        data[i].nilaiMonth6_1 = getMonthResult(data[i-6].signal, data[i].signal_crisis)
                        data[i].nilaiMonth6_2 = data[i].nilaiMonth6_1 ** 2
                        data[i].nilaiMonth12_1 = getMonthResult(data[i-12].signal, data[i].signal_crisis)
                        data[i].nilaiMonth12_2 = data[i].nilaiMonth12_1 ** 2
                        data[i].nilaiMonth24_1 = null
                        data[i].nilaiMonth24_2 = null
                        result[i] = data[i]
                    }

                    if (parseInt(data[i].tahun) > 2011 ) {
                        data[i].month1 = getMonthValue(data[i-1].signal, data[i].signal_crisis)
                        data[i].month3 = getMonthValue(data[i-3].signal, data[i].signal_crisis)
                        data[i].month6 = getMonthValue(data[i-6].signal, data[i].signal_crisis)
                        data[i].month12 = getMonthValue(data[i-12].signal, data[i].signal_crisis)
                        data[i].month24 = getMonthValue(data[i-24].signal, data[i].signal_crisis)
                        data[i].nilaiMonth1_1 = getMonthResult(data[i-1].signal, data[i].signal_crisis)
                        data[i].nilaiMonth1_2 = data[i].nilaiMonth1_1 ** 2
                        data[i].nilaiMonth3_1 = getMonthResult(data[i-3].signal, data[i].signal_crisis)
                        data[i].nilaiMonth3_2 = data[i].nilaiMonth3_1 ** 2
                        data[i].nilaiMonth6_1 = getMonthResult(data[i-6].signal, data[i].signal_crisis)
                        data[i].nilaiMonth6_2 = data[i].nilaiMonth6_1 ** 2
                        data[i].nilaiMonth12_1 = getMonthResult(data[i-12].signal, data[i].signal_crisis)
                        data[i].nilaiMonth12_2 = data[i].nilaiMonth12_1 ** 2
                        data[i].nilaiMonth24_1 = getMonthResult(data[i-24].signal, data[i].signal_crisis)
                        data[i].nilaiMonth24_2 = data[i].nilaiMonth24_1 ** 2
                        result[i] = data[i]
                    }
                }
                return result
            }

            async function filterRangkumanMonthnByYear(data) {
                let sigmaMonth1 = null
                let sigmaMonth3 = null
                let sigmaMonth6  = null
                let sigmaMonth12  = null
                let sigmaMonth24 = null
                let sumA_month1 = 0
                let sumA_month3 = 0
                let sumA_month6 = 0
                let sumA_month12 = 0
                let sumA_month24 = 0
                let sumB_month1 = 0
                let sumB_month3 = 0
                let sumB_month6 = 0
                let sumB_month12 = 0
                let sumB_month24 = 0
                let sumC_month1 = 0
                let sumC_month3 = 0
                let sumC_month6 = 0
                let sumC_month12 = 0
                let sumC_month24 = 0
                let sumD_month1 = 0
                let sumD_month3 = 0
                let sumD_month6 = 0
                let sumD_month12 = 0
                let sumD_month24 = 0
                let averageP_month1 = 0
                let averageP_month3 = 0
                let averageP_month6 = 0
                let averageP_month12 = 0
                let averageP_month24 = 0
                let averageR_month1 = 0
                let averageR_month3 = 0
                let averageR_month6 = 0
                let averageR_month12 = 0
                let averageR_month24 = 0
                
                let jumlah_month1 = 0
                let jumlah_month3 = 0
                let jumlah_month6 = 0
                let jumlah_month12 = 0
                let jumlah_month24 = 0
                let tempSumSignalSMonth1 = 0
                let tempSumSignalSMonth3 = 0
                let tempSumSignalSMonth6 = 0
                let tempSumSignalSMonth12 = 0
                let tempSumSignalSMonth24 = 0
                let tempSumSignalCMonth1 = 0
                let tempSumSignalCMonth3 = 0
                let tempSumSignalCMonth6 = 0
                let tempSumSignalCMonth12 = 0
                let tempSumSignalCMonth24 = 0
                
                for (let i = 0; i < data.length; i++) {
                    sigmaMonth1 = sigmaMonth1 + data[i].nilaiMonth1_2
                    sigmaMonth3 = sigmaMonth3 + data[i].nilaiMonth3_2
                    sigmaMonth6 = sigmaMonth6 + data[i].nilaiMonth6_2
                    sigmaMonth12 = sigmaMonth12 + data[i].nilaiMonth12_2
                    sigmaMonth24 = sigmaMonth24 + data[i].nilaiMonth24_2

                    data[i].month1 === null ? jumlah_month1 + 0  : jumlah_month1++
                    data[i].month3 === null ? jumlah_month3 + 0  : jumlah_month3++
                    data[i].month6 === null ? jumlah_month6 + 0  : jumlah_month6++
                    data[i].month12 === null ?  jumlah_month12 + 0  : jumlah_month12++
                    data[i].month24 === null ?  jumlah_month24 + 0 : jumlah_month24++

                    data[i].month1 == 'A' ? sumA_month1++ : sumA_month1 + 0 
                    data[i].month3 == 'A' ? sumA_month3++ : sumA_month3 + 0 
                    data[i].month6 == 'A' ? sumA_month6++ : sumA_month6 + 0 
                    data[i].month12 == 'A' ? sumA_month12++  : sumA_month12 + 0 
                    data[i].month24 == 'A' ? sumA_month24++  : sumA_month24 + 0

                    data[i].month1 == 'B' ? sumB_month1++ : sumB_month1 + 0 
                    data[i].month3 == 'B' ? sumB_month3++ : sumB_month3 + 0 
                    data[i].month6 == 'B' ? sumB_month6++ : sumB_month6 + 0 
                    data[i].month12 == 'B' ? sumB_month12++  : sumB_month12 + 0 
                    data[i].month24 == 'B' ? sumB_month24++  : sumB_month24 + 0 

                    data[i].month1 == 'C' ? sumC_month1++ : sumC_month1 + 0 
                    data[i].month3 == 'C' ? sumC_month3++ : sumC_month3 + 0 
                    data[i].month6 == 'C' ? sumC_month6++ : sumC_month6 + 0 
                    data[i].month12 == 'C' ? sumC_month12++  : sumC_month12 + 0 
                    data[i].month24 == 'C' ? sumC_month24++  : sumC_month24 + 0 

                    data[i].month1 == 'D' ? sumD_month1++ : sumD_month1 + 0 
                    data[i].month3 == 'D' ? sumD_month3++ : sumD_month3 + 0 
                    data[i].month6 == 'D' ? sumD_month6++ : sumD_month6 + 0 
                    data[i].month12 == 'D' ? sumD_month12++  : sumD_month12 + 0 
                    data[i].month24 == 'D' ? sumD_month24++  : sumD_month24 + 0 
                    
                    data[i].month1 === null ? tempSumSignalSMonth1 = 0 + tempSumSignalSMonth1 : tempSumSignalSMonth1 = data[i].signal + tempSumSignalSMonth1
                    data[i].month1 === null ? tempSumSignalCMonth1 = 0 + tempSumSignalCMonth1 : tempSumSignalCMonth1 = data[i].signal_crisis + tempSumSignalCMonth1
                    data[i].month3 === null ? tempSumSignalSMonth3 = 0 + tempSumSignalSMonth3 : tempSumSignalSMonth3 = data[i].signal + tempSumSignalSMonth3
                    data[i].month3 === null ? tempSumSignalCMonth3 = 0 + tempSumSignalCMonth3 : tempSumSignalCMonth3 = data[i].signal_crisis + tempSumSignalCMonth3
                    data[i].month6 === null ? tempSumSignalSMonth6 = 0 + tempSumSignalSMonth6 : tempSumSignalSMonth6 = data[i].signal + tempSumSignalSMonth6
                    data[i].month6 === null ? tempSumSignalCMonth6 = 0 + tempSumSignalCMonth6 : tempSumSignalCMonth6 = data[i].signal_crisis + tempSumSignalCMonth6
                    data[i].month12 === null ? tempSumSignalSMonth12 = 0 + tempSumSignalSMonth12 : tempSumSignalSMonth12 = data[i].signal + tempSumSignalSMonth12
                    data[i].month12 === null ? tempSumSignalCMonth12 = 0 + tempSumSignalCMonth12 : tempSumSignalCMonth12 = data[i].signal_crisis + tempSumSignalCMonth12
                    data[i].month24 === null ? tempSumSignalSMonth24 = 0 + tempSumSignalSMonth24 : tempSumSignalSMonth24 = data[i].signal + tempSumSignalSMonth24
                    data[i].month24 === null ? tempSumSignalCMonth24 = 0 + tempSumSignalCMonth24 : tempSumSignalCMonth24 = data[i].signal_crisis + tempSumSignalCMonth24
                }
                averageP_month1 = tempSumSignalSMonth1 / jumlah_month1
                averageP_month3 = tempSumSignalSMonth3 / jumlah_month3
                averageP_month6 = tempSumSignalSMonth6 / jumlah_month6
                averageP_month12 = tempSumSignalSMonth12 / jumlah_month12
                averageP_month24 = tempSumSignalSMonth24 / jumlah_month24
                averageR_month1 = tempSumSignalCMonth1 / jumlah_month1
                averageR_month3 = tempSumSignalCMonth3 / jumlah_month3
                averageR_month6 = tempSumSignalCMonth6 / jumlah_month6
                averageR_month12 = tempSumSignalCMonth12 / jumlah_month12
                averageR_month24 = tempSumSignalCMonth24 / jumlah_month24


                let result = []

                result [1] = []
                result[1][0] = '<strong>3 Month</strong>'
                result[1][1] = jumlah_month3 == 0 ? 'N/A' :  sumA_month3
                result[1][2] = jumlah_month3 == 0 ? 'N/A' :  sumB_month3
                result[1][3] = jumlah_month3 == 0 ? 'N/A' :  sumC_month3
                result[1][4] = jumlah_month3 == 0 ? 'N/A' :  sumD_month3
                result[1][5] = jumlah_month3 == 0 ? 'N/A' : jumlah_month3
                result[1][6] = '0.5'
                result[1][7] = jumlah_month3 == 0 ? 'N/A' :  ((sumA_month3 + sumD_month3) / jumlah_month3)
                result[1][8] = jumlah_month3 == 0 ? 'N/A' :  Object.is(NaN,((sumA_month3 / (sumA_month3 + sumC_month3)))) ? 0 : ((sumA_month3 / (sumA_month3 + sumC_month3)))
                result[1][9] = jumlah_month3 == 0 ? 'N/A' :  Object.is(NaN,((sumB_month3 / (sumB_month3 + sumD_month3))))  ? 0 : (sumB_month3 / (sumB_month3 + sumD_month3))
                result[1][10] = jumlah_month3 == 0 ? 'N/A' :  0.5 * result[1][7] * result[1][8]
                result[1][11] = jumlah_month3 == 0 ? 'N/A' :  (((1-0.5) * (1 - result[1][7])) * result[1][9])
                result[1][12] = jumlah_month3 == 0 ? 'N/A' :  result[1][10] + result[1][11]
                result[1][13] = jumlah_month3 == 0 ? 'N/A' :  ((1 / jumlah_month3) * sigmaMonth3)
                result[1][14] = jumlah_month3 == 0 ? 'N/A' :  (2 * ((averageP_month3 - averageR_month3) ** 2))
                result[1][15] = jumlah_month3 == 0 ? 'N/A' :  Object.is(NaN,(sumC_month3 / (sumC_month3 + sumD_month3))) ? 0 : (sumC_month3 / (sumC_month3 + sumD_month3))
                result[1][16] = jumlah_month3 == 0 ? 'N/A' :  Object.is(NaN,(sumB_month3 / (sumB_month3 + sumD_month3))) ? 0 : (sumB_month3 / (sumB_month3 + sumD_month3))
                result[1][17] = jumlah_month3 == 0 ? 'N/A' :  1 - result[1][12]

                result[2] = []
                result[2][0] = '<strong>6 Month</strong>'
                result[2][1] = jumlah_month6 == 0 ? 'N/A' :  sumA_month6
                result[2][2] = jumlah_month6 == 0 ? 'N/A' :  sumB_month6
                result[2][3] = jumlah_month6 == 0 ? 'N/A' :  sumC_month6
                result[2][4] = jumlah_month6 == 0 ? 'N/A' :  sumD_month6
                result[2][5] = jumlah_month6 == 0 ? 'N/A' : jumlah_month6
                result[2][6] = '0.5'
                result[2][7] = jumlah_month6 == 0 ? 'N/A' :  ((sumA_month6 + sumD_month6) / jumlah_month6)
                result[2][8] = jumlah_month6 == 0 ? 'N/A' :  Object.is(NaN,((sumA_month6 / (sumA_month6 + sumC_month6)))) ? 0 : ((sumA_month6 / (sumA_month6 + sumC_month6)))
                result[2][9] = jumlah_month6 == 0 ? 'N/A' :  Object.is(NaN,((sumB_month6 / (sumB_month6 + sumD_month6))))  ? 0 : (sumB_month6 / (sumB_month6 + sumD_month6))
                result[2][10] = jumlah_month6 == 0 ? 'N/A' :  0.5 * result[2][7] * result[2][8]
                result[2][11] = jumlah_month6 == 0 ? 'N/A' :  (((1-0.5) * (1 - result[2][7])) * result[2][9])
                result[2][12] = jumlah_month6 == 0 ? 'N/A' :  result[2][10] + result[2][11]
                result[2][13] = jumlah_month6 == 0 ? 'N/A' :  ((1 / jumlah_month6) * sigmaMonth6)
                result[2][14] = jumlah_month6 == 0 ? 'N/A' :  (2 * ((averageP_month6 - averageR_month6) ** 2))
                result[2][15] = jumlah_month6 == 0 ? 'N/A' :  Object.is(NaN,(sumC_month6 / (sumC_month6 + sumD_month6))) ? 0 : (sumC_month6 / (sumC_month6 + sumD_month6))
                result[2][16] = jumlah_month6 == 0 ? 'N/A' :  Object.is(NaN,(sumB_month6 / (sumB_month6 + sumD_month6))) ? 0 : (sumB_month6 / (sumB_month6 + sumD_month6))
                result[2][17] = jumlah_month6 == 0 ? 'N/A' :  1 - result[2][12]

                result[3] = []
                result[3][0] = '<strong>12 Month</strong>'
                result[3][1] = jumlah_month12 == 0 ? 'N/A' :  sumA_month12
                result[3][2] = jumlah_month12 == 0 ? 'N/A' :  sumB_month12
                result[3][3] = jumlah_month12 == 0 ? 'N/A' :  sumC_month12
                result[3][4] = jumlah_month12 == 0 ? 'N/A' :  sumD_month12
                result[3][5] = jumlah_month12 == 0 ? 'N/A' : jumlah_month12
                result[3][6] = '0.5'
                result[3][7] = jumlah_month12 == 0 ? 'N/A' :  ((sumA_month12 + sumD_month12) / jumlah_month12)
                result[3][8] = jumlah_month12 == 0 ? 'N/A' :  Object.is(NaN,((sumA_month12 / (sumA_month12 + sumC_month12)))) ? 0 : ((sumA_month12 / (sumA_month12 + sumC_month12)))
                result[3][9] = jumlah_month12 == 0 ? 'N/A' :  Object.is(NaN,((sumB_month12 / (sumB_month1 + sumD_month12))))  ? 0 : (sumB_month12 / (sumB_month12 + sumD_month12))
                result[3][10] = jumlah_month12 == 0 ? 'N/A' :  0.5 * result[3][7] * result[3][8]
                result[3][11] = jumlah_month12 == 0 ? 'N/A' :  (((1-0.5) * (1 - result[3][7])) * result[3][9])
                result[3][12] = jumlah_month12 == 0 ? 'N/A' :  result[3][10] + result[3][11]
                result[3][13] = jumlah_month12 == 0 ? 'N/A' :  ((1 / jumlah_month12) * sigmaMonth12)
                result[3][14] = jumlah_month12 == 0 ? 'N/A' :  (2 * ((averageP_month12 - averageR_month12) ** 2))
                result[3][15] = jumlah_month12 == 0 ? 'N/A' :  Object.is(NaN,(sumC_month12 / (sumC_month12 + sumD_month12))) ? 0 : (sumC_month12 / (sumC_month12 + sumD_month12))
                result[3][16] = jumlah_month12 == 0 ? 'N/A' :  Object.is(NaN,(sumB_month12 / (sumB_month12 + sumD_month12))) ? 0 : (sumB_month12 / (sumB_month12 + sumD_month12))
                result[3][17] = jumlah_month12 == 0 ? 'N/A' :  1 - result[3][12]

                result[4] = []
                result[4][0] = '<strong>24 Month</strong>'
                result[4][1] = jumlah_month24 == 0 ? 'N/A' :  sumA_month24
                result[4][2] = jumlah_month24 == 0 ? 'N/A' :  sumB_month24
                result[4][3] = jumlah_month24 == 0 ? 'N/A' :  sumC_month24
                result[4][4] = jumlah_month24 == 0 ? 'N/A' :  sumD_month24
                result[4][5] = jumlah_month24 == 0 ? 'N/A' : jumlah_month24
                result[4][6] = '0.5'
                result[4][7] = jumlah_month24 == 0 ? 'N/A' :  ((sumA_month24 + sumD_month24) / jumlah_month24)
                result[4][8] = jumlah_month24 == 0 ? 'N/A' :  Object.is(NaN,((sumA_month24 / (sumA_month24 + sumC_month24)))) ? 0 : ((sumA_month24 / (sumA_month24 + sumC_month24)))
                result[4][9] = jumlah_month24 == 0 ? 'N/A' :  Object.is(NaN,((sumB_month24 / (sumB_month24 + sumD_month24))))  ? 0 : (sumB_month24 / (sumB_month24 + sumD_month24))
                result[4][10] = jumlah_month24 == 0 ? 'N/A' :  0.5 * result[4][7] * result[4][8]
                result[4][11] = jumlah_month24 == 0 ? 'N/A' :  (((1-0.5) * (1 - result[4][7])) * result[4][9])
                result[4][12] = jumlah_month24 == 0 ? 'N/A' :  result[4][10] + result[4][11]
                result[4][13] = jumlah_month24 == 0 ? 'N/A' :  ((1 / jumlah_month24) * sigmaMonth24)
                result[4][14] = jumlah_month24 == 0 ? 'N/A' :  (2 * ((averageP_month24 - averageR_month24) ** 2))
                result[4][15] = jumlah_month24 == 0 ? 'N/A' :  Object.is(NaN,(sumC_month24 / (sumC_month24 + sumD_month24))) ? 0 : (sumC_month24 / (sumC_month24 + sumD_month24))
                result[4][16] = jumlah_month24 == 0 ? 'N/A' :  Object.is(NaN,(sumB_month24 / (sumB_month24 + sumD_month24))) ? 0 : (sumB_month24 / (sumB_month24 + sumD_month24))
                result[4][17] = jumlah_month24 == 0 ? 'N/A' :  1 - result[4][12]
                
                return result
            }

            async function  getLowGsb(data) {
                let lowIndex;
                let low = 999;
                let index = [3,6,12,24]

                for (let i = 1; i < data.length; i++) {
                    if (data[i][14] < low) {
                        low = data[i][14]
                        lowIndex = i-1
                    }
                    
                }
                return index[lowIndex];
            }

            // Get month time horizon value
            function getMonthValue(signal, crisis) {
                let result
                if (signal && crisis) {
                    result =  'A'
                } else if(signal && !crisis){
                    result =  'B'
                } else if(!signal && crisis){
                    result =  'C'
                } else {
                   result = 'D'
                }

                return result
            }

            // Get month time horizon value
            function getMonthResult(signal, crisis) {
                var result = 2 * (signal - crisis)
                return parseFloat(result)
            }

            //for chart
            async function generateChart(data) {

                new Chart(
                    document.getElementById('chart-section'),
                    {
                    type: 'line',
                    data: {
                        labels: data.month.map(row => row),
                        datasets: [
                        {
                            label: data.name,
                            data: data.value_index.map(row => row)
                        },
                        {
                            label: data.upperTh.name,
                            data: data.upperTh.data.map(row => row)
                        },
                        {
                            label: data.lowerTh.name,
                            data: data.lowerTh.data.map(row => row)
                        },
                        {
                            label: data.average.name,
                            data: data.average.data.map(row => row)
                        }
                        ]
                    }
                    }
                );
            };
        })
    </script>
@endpush
