@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px] h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Setting the Heat Map</h1>
        <p class="mb-5">{{ __('heatmap.desc') }}</p>

        <div class="inline-block flex">
            
            <select id="selectYears" class="bg-gray-50 mb-4 border border-ld-green/50 text-gray-900 text-sm rounded-lg focus:ring-ld-green/50 focus:border-ld-green/50 block w-[100px] p-2.5" style="margin-right: 10px"></select>
            
            <select id="selectCountry" class="bg-gray-50 mb-4 border border-ld-green/50 text-gray-900 text-sm rounded-lg focus:ring-ld-green/50 focus:border-ld-green/50 block w-[100px] p-2.5">
                @foreach(list_country() as $country)
                <option value="{{ $country->code }}"  {{ $country->code ==  \Route::current()->parameter('code') ? 'selected' : '' }}>{{ $country->nama_negara }}</option>
                @endforeach
            </select>
        </div>

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
                        <th class="p-4">Des</th>
                    </tr>
                </thead>
                <tbody class="skalz-tbody">

                </tbody>
            </table>
        </div>

    </section>
@endsection

@push('scripts')
    {{-- <script>
        $(document).ready(function() {

            const data = [{
                    "var": "NPF%",
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
                    "var": "CAR%",
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
                    "var": "IPR%",
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
                    "var": "FDR%",
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
                    "var": "CI%",
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
                $('.skalz-tbody').append(`
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
    </script> --}}
    <script>
        $(document).ready(function() {

            const tahun = {!! json_encode($tahun) !!}
            const variable = {!! json_encode($variable) !!}
            const averageGlobal = {{ $avg}}
            let bulan = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
            
            let dataAll = [];
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

            Object.keys(tahun).forEach((key, index) => {
                $('#selectYears').append(`<option value="${tahun[key].tahun}">${tahun[key].tahun}</option>`)
            })

            $('#selectVariable').on('change', function () {
                $('.skalz-tbody').html('')

                renderTable()
            })

            $('#selectYears').on('change', function () {
                $('.skalz-tbody').html('')

                renderTable()
            })

            const options = {
                defaultTabId: 'settings',
                activeClasses: 'text-ds-blue hover:text-ds-blue border-ds-blue',
                inactiveClasses: 'text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300',
                onShow: () => {}
            }

            boot()    

            async function getAllData(){
                let j = 0
                for (let property in variable) {
                    let signal = await reqSignal(variable[property].id)
                    let dataVar = await reqDataVar(variable[property].id)
                    let signalLow = await reqSignalLow(variable[property].id)
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
                    let temp = {
                        var_id:variable[property].id,
                        name:variable[property].nama_variable,
                        dataVar:dataVar,
                        stDev:stDev,
                        mean:mean,
                        meanTotal:meanTotal,
                        lowGsb:lowGsb,
                        stDevLow:stDevLow,
                        meanLow:meanLow,
                        lowGsbLow:lowGsbLow
                    }
                    dataAll.push(temp)
                }

                return dataAll
            }

            async function boot() {
                let firstData = await getAllData()
                renderTable()
            }


            async function renderTable() {
                year = $('#selectYears').val()
                renderData(year)
                
            }

            async function reqDataVar(fVariable) {
                try {
                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.macro.optimallevelreal.data', ['code' => \Route::current()->parameter('code')]) }}',
                        headers: {},
                        params: {
                            'variable': fVariable
                        }
                    })

                    const data = signal.data

                    if(data.code === 200) {
                        return data.data
                    } else {
                        toastr.error(data.message)
                    }

                } catch (error) {
                    toastr.error(error.message)
                }
            }

            async function reqSignal(fVariable) {
                try {
                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.macro.ews.signal', ['code' => \Route::current()->parameter('code')]) }}',
                        headers: {},
                        params: {
                            'variable': fVariable
                        }
                    })

                    const data = signal.data

                    if(data.code === 200) {
                        return data.data
                    } else {
                        toastr.error(data.message)
                    }

                } catch (error) {
                    toastr.error(error.message)
                }
            }

            async function reqSignalLow(fVariable) {
                try {
                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.macro.ews.signal-lower', ['code' => \Route::current()->parameter('code')]) }}',
                        headers: {},
                        params: {
                            'variable': fVariable
                        }
                    })

                    const data = signal.data

                    if(data.code === 200) {
                        return data.data
                    } else {
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

            async function renderData(year){
                dataAll.forEach(data => {
                    console.log(data);
                    let upper = data.mean + (averageGlobal * data.stDev)
                    let lower = data.meanLow - (averageGlobal * data.stDevLow)
                    var desc
                    $('.skalz-tbody').append(`<tr style="background-color:rgb(0 64 41 / 0.1)">`)
                        $('.skalz-tbody').append(`<td class="p-2"><strong>${data.name}%</strong></td>`)
                        data.dataVar.forEach(el => {
                            if (el.tahun == year) {
                                desc = getDescription(el.value, upper, data.meanTotal, lower, data.var_id);
                                color = getColor(desc)
                                $('.skalz-tbody').append(`<td class="p-2" style="background-color:${color}" >${el.value.toFixed(2)}</td>`)
                            }   
                        });
                    });
                    // $('.skalz-tbody').append(`</tr>`)
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
                    url: "{{ route('dashboard.stdev', ['code' => \Route::current()->parameter('code')]) }}",
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
                    return 'Vulnerability'
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
                    return 'Vulnerability'
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

            function getColor(desc) {
                switch (desc) {
                    case 'Expected/Optimal':
                        return 'green';
                        break;
                    case 'Tolerance':
                        return 'yellow';
                        break;
                    case 'Vulnerability':
                        return 'red';
                        break;
                    case 'Stagnant/Strict':
                        return 'blue';
                        break;
                    default:
                        return 'none';
                        break;
                }
            }
        })
    </script>
@endpush
