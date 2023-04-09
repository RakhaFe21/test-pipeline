@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Lower Threshold</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Macro, Data, EWS - Out sample Mode, Lower Threshold</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <select
                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[50px] p-3.5" id="selectVariable">
            </select>
        </div>

        <div class="box-border h-32 w-32 p-4 border-4 bg-gray-100 rounded-lg mb-4">
            <div class="inline-block flex">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="tabel">
                        Tabel
                    </label>
                    <select
                        class="bg-gray-50 flex w-full border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray p-3.5 mr-4" id="selectTable">
                    </select>
                </div>
                <div class="mb-4" id="tahun-section">
                    <label class="block text-gray-700 text-sm mb-2 ml-4" for="tahun">
                        Tahun
                    </label>
                    <select
                        class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray flex w-full w-[100px] p-3.5 ml-4" id="selectYear">
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4" id="tableDiv1">
            <table class="w-full text-sm text-left text-center" id="signalCrisisTable">
                <thead class="text-xs uppercase bg-gray-200" id="headerSCTable">
                    <tr>
                        <th scope="col" class="py-3 px-6">MONTHS</th>
                        <th scope="col" class="py-3 px-6">Signal S</th>
                        <th scope="col" class="py-3 px-6">Signal C</th>
                    </tr>
                </thead>
                <tbody id="bodySCTable">

                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4 hidden" id="tableDiv2">
            <table class="w-full text-sm text-left text-center" id="horizonTable">
                <thead class="text-xs uppercase bg-gray-200" id="headerHorizonTable">
                    <tr>
                        <th scope="col" rowspan="2" class="py-3 px-6">Year</th>
                        <th scope="col" colspan="6" class="py-3 px-6">Time Horizon (MONTH)</th>
                    </tr>
                    <tr>
                        <th scope="col" class="py-3 px-6">MONTHS</th>
                        <th scope="col" class="py-3 px-6">1</th>
                        <th scope="col" class="py-3 px-6">3</th>
                        <th scope="col" class="py-3 px-6">6</th>
                        <th scope="col" class="py-3 px-6">12</th>
                        <th scope="col" class="py-3 px-6">24</th>
                    </tr>                
                </thead>
                <tbody class="skalz-tbody" id="bodyHorizonTable">

                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4 hidden horizontal-scrollable" id="tableDiv3">
            <table class="w-full text-sm text-left text-center" id="ValueMonth">
                <thead class="text-xs uppercase bg-gray-200" id="headerValueMonth">
                    <tr>
                        <th scope="col" rowspan="2" class="py-3 px-6">Year</th>
                        <th scope="col" rowspan="2" class="py-3 px-6">MONTH</th>
                        <th scope="col" colspan="2" class="py-3 px-6">1</th>
                        <th scope="col" colspan="2" class="py-3 px-6">3</th>
                        <th scope="col" colspan="2" class="py-3 px-6">6</th>
                        <th scope="col" colspan="2" class="py-3 px-6">12</th>
                        <th scope="col" colspan="2" class="py-3 px-6">24</th>
                    </tr>
                    <tr>
                        <th scope="col" class="py-3 px-6">2*(P-R)</th>
                        <th scope="col" class="py-3 px-6">(2*(P-R))^2</th>
                        <th scope="col" class="py-3 px-6">2*(P-R)</th>
                        <th scope="col" class="py-3 px-6">(2*(P-R))^2</th>
                        <th scope="col" class="py-3 px-6">2*(P-R)</th>
                        <th scope="col" class="py-3 px-6">(2*(P-R))^2</th>
                        <th scope="col" class="py-3 px-6">2*(P-R)</th>
                        <th scope="col" class="py-3 px-6">(2*(P-R))^2</th>
                        <th scope="col" class="py-3 px-6">2*(P-R)</th>
                        <th scope="col" class="py-3 px-6">(2*(P-R))^2</th>
                    </tr>                
                </thead>
                <tbody class="skalz-tbody" id="bodyValueMonth">

                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4 hidden " id="tableDiv4">
            <table class="w-full text-sm text-left text-center" id="ResultMonth">
                <thead class="text-xs uppercase bg-gray-200" id="headerResultMonth">
                    <tr>
                        <th scope="col" colspan="2" class="py-3 px-6">1</th>
                        <th scope="col" colspan="2" class="py-3 px-6">3</th>
                        <th scope="col" colspan="2" class="py-3 px-6">6</th>
                        <th scope="col" colspan="2" class="py-3 px-6">12</th>
                        <th scope="col" colspan="2" class="py-3 px-6">24</th>
                    </tr>               
                </thead>
                <tbody class="skalz-tbody" id="bodyResultMonth">

                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4 hidden horizontal-scrollable" id="tableDiv5">
            <table class="w-full text-sm text-left text-center" id="SummaryMonth">
                <thead class="text-xs uppercase bg-gray-200" id="headerSummaryMonth">
                    <tr>
                        <th scope="col" class="py-3 px-6">MONTHS</th>
                        <th scope="col" class="py-3 px-6">A</th>
                        <th scope="col" class="py-3 px-6">B</th>
                        <th scope="col" class="py-3 px-6">C</th>
                        <th scope="col" class="py-3 px-6">D</th>
                        <th scope="col" class="py-3 px-6">N</th>
                        <th scope="col" class="py-3 px-6">µ</th>
                        <th scope="col" class="py-3 px-6">P</th>
                        <th scope="col" class="py-3 px-6">T1(Type1Error)</th>
                        <th scope="col" class="py-3 px-6">T2(Type2Error)</th>
                        <th scope="col" class="py-3 px-6">L1</th>
                        <th scope="col" class="py-3 px-6">L2</th>
                        <th scope="col" class="py-3 px-6">Lost Function <br> (L)</th>
                        <th scope="col" class="py-3 px-6">QPS</th>
                        <th scope="col" class="py-3 px-6">GSB</th>
                        <th scope="col" class="py-3 px-6">C(Probability of Crises <br> Without Signal)</th>
                        <th scope="col" class="py-3 px-6">B(Probability of No Crises <br> With Signal)-Resilience</th>
                        <th scope="col" class="py-3 px-6">Resilience</th>
                    </tr>               
                </thead>
                <tbody class="skalz-tbody" id="bodySummaryMonth">
                   
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const tahun = {!! json_encode($tahun) !!}
            const variable = {!! json_encode($variable) !!}
            let bulan = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

            Object.keys(variable).forEach((key, index) => {
                $('#selectVariable').append(`
                    <option value="${variable[key].id}">I${variable[key].nama_variable.toUpperCase()}</option>`)
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

            Object.keys(tahun).forEach((key, index) => {
                $('#selectYear').append(`
                    <option value="${tahun[key].tahun}">${tahun[key].tahun}</option>
                `)
            })

            const table = [
                {
                    "table": "tableDiv1",
                    "title": "Signal (S) & Crisis (C)",
                    "function": getSignal($('#selectVariable').val(), $('#selectYear').val())
                },
                {
                    "table": "tableDiv2",
                    "title": "Time Horizon (Month)"
                },
                {
                    "table": "tableDiv3",
                    "title": "Nilai 1, 3, 6, 12, 24 Bulan"
                },
                {
                    "table": "tableDiv4",
                    "title": "Hasil Nilai 1, 3, 6, 12, 24 Bulan"
                },
                {
                    "table": "tableDiv5",
                    "title": "Rangkuman Lower Treshold"
                }
            ]

            Object.keys(table).forEach((key, index) => {
                $('#selectTable').append(`
                    <option value="${table[key].table}">${table[key].title}</option>
                `)
            })

            /* Get active table */
            let tableActive = $('#selectTable').val()
            $('#'+tableActive).removeClass('hidden')

            $('#selectVariable').on('change', function () {
                // let variable = $('#selectVariable').val()
                // let year = $('#selectYear').val()
                // getSignal(variable, year)
                tableChange($('#selectTable').val())
            })

            $('#selectYear').on('change', function () {
                // let variable = $('#selectVariable').val()
                // let year = $('#selectYear').val()
                // getSignal(variable, year)
                tableChange($('#selectTable').val())
            })

            function tableChange(table) {
                $('.skalz-tbody').html('')
                if (table === 'tableDiv1') {
                    $('#tahun-section').css({
                        display: "inline",
                        visibility: "visible"
                    });
                    let variable = $('#selectVariable').val()
                    let year = $('#selectYear').val()
                    getSignal(variable, year)
                } else if (table === 'tableDiv2'){
                    $('#tahun-section').css({
                        display: "inline",
                        visibility: "visible"
                    });
                    countHorizon()
                } else if (table === 'tableDiv3'){
                    $('#tahun-section').css({
                        display: "inline",
                        visibility: "visible"
                    });
                    getValueMonth()
                } else if (table === 'tableDiv4'){
                    $('#tahun-section').css({
                        display: "none",
                        visibility: "hidden"
                    });
                    getResultMonth()
                } else {
                    $('#tahun-section').css({
                        display: "none",
                        visibility: "hidden"
                    });
                    getRangkumanYear()
                }
            }

            $('#selectTable').on('change', function() {
                let id = $('#selectTable').val()
                Object.keys(table).forEach((key, index) => {
                    if(id == table[key].table) {
                        $('#' + id).removeClass('hidden')
                    } else {
                        $('#' + table[key].table).addClass('hidden')
                    }
                })
                tableChange(id)
            })

            function dataObject(data, tahun)
            {
                let fData = []
                let signal = []
                for (let i = 0; i < data.length; i++) {
                    if(data[i].tahun == tahun) {
                        fData.push(data[i])
                    }
                }
                renderTable(fData)
            }

            function renderTable(fData) {
                Object.keys(fData).forEach((key, index) => {

                    let signalC = (fData[key].value_index < fData[key].average)?1:0

                    $('#bodySCTable').append(`
                            <tr>
                                <td class="border border-slate-300 py-4 px-6">` + months(fData[key].bulan) + `</td>
                                <td class="border border-slate-300 py-4 px-6">${fData[key].signal.toFixed(2)}</td>
                                <td class="border border-slate-300 py-4 px-6">${signalC.toFixed(2)}</td>
                            </tr>
                        `)
                })
            }

            /* Get Signal S & C */
            async function getSignal(variable, year) {
                try {
                    const fVariable = (variable=='')?$('#selectVariable').val():variable
                    const fTahun = (year=='')?$('#selectYear').val():year
                    $('#bodySCTable').html('')

                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.ibri.ews.signal-lower') }}',
                        headers: {},
                        params: {
                            'variable': fVariable,
                            'tahun': fTahun
                        }
                    })

                    const data = signal.data

                    if(data.code === 200) {
                        dataObject(data.data, fTahun)
                    } else {
                        toastr.error(data.message)
                    }

                } catch (error) {
                    toastr.error(error.message)
                }
            }

            /* Skalz*/

            async function reqSignal(variable, year) {
                try {
                    const fVariable = (variable=='')?$('#selectVariable').val():variable
                    const fTahun = (year=='')?$('#selectYear').val():year
                    const signal = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.ibri.ews.signal') }}',
                        headers: {},
                        params: {
                            'variable': fVariable,
                            'tahun': fTahun
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

            async function filterSignalByYear(data, year){
                let fData = []
                console.log(data);
                // if (year === "2010") {
                //     for (let i = 0; i < data.length; i++) {
                //         if(data[i].tahun == year) {
                //             if (i < (data.length - 1)) {
                //                 data[i].signalC = (data[i].value_index > data[i].average)?1:0
        
                //                 if (data[i].signal && data[i].signalC) {
                //                     data[i+1].test_horizon1 =  'A'
                //                     data[i+1].test_horizon3 =  'A'
                //                     data[i+1].test_horizon6 =  'A'
                //                     data[i+1].test_horizon12=  'A'
                //                     data[i+1].test_horizon24 =  'A'
                //                 } else if(data[i].signal && !data[i].signalC){
                //                     data[i+1].test_horizon1 =  'B'
                //                     data[i+1].test_horizon3 =  'B'
                //                     data[i+1].test_horizon6 =  'B'
                //                     data[i+1].test_horizon12=  'B'
                //                     data[i+1].test_horizon24 =  'B'
                //                 } else if(!data[i].signal && data[i].signalC){
                //                     data[i+1].test_horizon1 =  'C'
                //                     data[i+1].test_horizon3 =  'C'
                //                     data[i+1].test_horizon6 =  'C'
                //                     data[i+1].test_horizon12=  'C'
                //                     data[i+1].test_horizon24 =  'C'
                //                 } else {
                //                     data[i].test_horizon1 =  'D'
                //                     data[i].test_horizon3 =  'D'
                //                     data[i].test_horizon6 =  'D'
                //                     data[i].test_horizon12=  'D'
                //                     data[i].test_horizon24 =  'D'
                //                 }
                //                 fData.push(data[i])
                //             }
                //         }
                //     }
                //     return fData
                // } else if (year === "2011"){
                //     for (let index = 0; index < array.length; index++) {
                //         const element = array[index];
                        
                //     }
                // }
            }

            async function filterGreenBlockByYear(data){
                
                if (data[0].tahun === "2010") {
                    for (let i = 0; i < data.length; i++) {
                        switch (i) {
                            case 0:
                                data[i].test_horizon1 =  ""
                                data[i].test_horizon3 =  ""
                                data[i].test_horizon6 =  ""
                                data[i].test_horizon12 =  ""
                                data[i].test_horizon24 =  ""
                                break
                            case 1:
                            case 2:
                                data[i].test_horizon3 =  ""
                                data[i].test_horizon6 =  ""
                                data[i].test_horizon12 =  ""
                                data[i].test_horizon24 =  ""
                                break
                            case 3:
                            case 4:
                            case 5:
                                data[i].test_horizon6 =  ""
                                data[i].test_horizon12 =  ""
                                data[i].test_horizon24 =  ""
                                break
                            case 6:
                            case 7:
                            case 8:
                            case 9:
                            case 10:
                            case 11:
                            case 12 :
                                data[i].test_horizon12 =  ""
                                data[i].test_horizon24 =  ""
                            default:
                                break;
                        }
                        
                    }
                } else if(data[0].tahun === "2011"){
                    for (let i = 0; i < data.length; i++) {
                        data[i].test_horizon24 =  ""
                    }
                }
                else{

                }

                return data
            }

            async function renderHorizon(data){
                $('#bodyHorizonTable').append(`
                    <tr>
                        <td rowspan="13"  class="border border-slate-300 py-4 px-6">${data[0].tahun}</td>
                    </tr>
                `)
                data.forEach(val => {
                    var monthName = bulan[val.bulan - 1];
                    $('#bodyHorizonTable').append(`
                        <tr>
                            <td class="border border-slate-300 py-4 px-6">${monthName}</td>
                            <td class="border border-slate-300 py-4 px-6" ${val.month1 === null ? 'style="background: #00B050"' : ''} >${val.month1 === null ?  '' :  val.month1  }</td>
                            <td class="border border-slate-300 py-4 px-6" ${val.month3 === null ? 'style="background: #00B050"' : ''} >${val.month3 === null ?  '' :  val.month3  }</td>
                            <td class="border border-slate-300 py-4 px-6" ${val.month6 === null ? 'style="background: #00B050"' : ''} >${val.month6 === null ?  '' :  val.month6  }</td>
                            <td class="border border-slate-300 py-4 px-6" ${val.month12 === null ? 'style="background: #00B050"' : ''} >${val.month12 === null ?   '' : val.month12 }</td>
                            <td class="border border-slate-300 py-4 px-6" ${val.month24 === null ? 'style="background: #00B050"' : ''} >${val.month24 === null ?   '' : val.month24  }</td>
                        </tr>
                    `)
                })
            }

            async function renderValueMonth(data){
                $('#bodyValueMonth').append(`
                    <tr>
                        <td rowspan="13"  class="border border-slate-300 py-4 px-6">${data[0].tahun}</td>
                    </tr>
                `)
                data.forEach(val => {
                    var monthName = bulan[val.bulan - 1];

                    $('#bodyValueMonth').append(`
                        <tr>
                            <td class="border border-slate-300 py-4 px-6">${monthName}</td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth1_1 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth1_1 === null ? '' : val.nilaiMonth1_1.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth1_2 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth1_2 === null ? '' : val.nilaiMonth1_2.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth3_1 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth3_1 === null ? '' : val.nilaiMonth3_1.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth3_2 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth3_2 === null ? '' : val.nilaiMonth3_2.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth6_1 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth6_1 === null ? '' : val.nilaiMonth6_1.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth6_2 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth6_2 === null ? '' : val.nilaiMonth6_2.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth12_1 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth12_1 === null ? '' : val.nilaiMonth12_1.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth12_2 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth12_2 === null ? '' : val.nilaiMonth12_2.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth24_1 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth24_1 === null ? '' : val.nilaiMonth24_1.toFixed(2)} </td>
                            <td class="border border-slate-300 py-4 px-6" ${val.nilaiMonth24_2 === null ? 'style="background: #00B050"' : ''}> ${val.nilaiMonth24_2 === null ? '' : val.nilaiMonth24_2.toFixed(2)} </td>
                        </tr>
                    `)
                })
            }
            
            async function renderResultMonth(data){
                data.forEach(tr => {
                    var td
                    var val 
                    tr.forEach((el, index) => {
                        val = typeof el[1] === "number" ? el[1].toFixed(3) : el[1] 
                       td += '<td class="border border-slate-300 py-4 px-6"><strong>'+el[0]+'</strong></td><td class="border border-slate-300 py-4 px-6">'+val+'</td>'
                    })
                    $('#bodyResultMonth').append(`
                        <tr>${td}</tr>
                    `)
                })
            }

            async function renderRangkuman(data) {
                data.forEach(tr => {
                    var td 
                    tr.forEach((el, index) => {
                        if (index < 6) {
                            val = el
                        } else if (index < 9){
                            val = typeof el === "number" ? el.toFixed(3) : el
                        } else {
                            val = typeof el === "number" ? el.toFixed(4) : el
                        }
                       td += '<td class="border border-slate-300 py-4 px-6">'+val +'</td>'
                    })
                    $('#bodySummaryMonth').append(`
                        <tr>${td}</tr>
                    `)
                })
            }

            // Get Time Horizon
            async function getHorizon() {
                let variable = $('#selectVariable').val()
                let year = $('#selectYear').val()
                let resultSignal = await reqSignal(variable, year)
                if (year === "2010") {
                    let resultFilter = await filterSignalByYear(resultSignal, year)
                    let resultBlock = await filterGreenBlockByYear(resultFilter)
                    renderHorizon(resultBlock)
                } else if(year === "2011"){
                    let  result = await reqSignal(variable, "2010")
                    let  filterResullt = await filterSignalByYear(resultSignal, year)
                }
            }

            // Get Value Month
            async function getValueMonth() {
                let variable = $('#selectVariable').val()
                let year = $('#selectYear').val()
                let resultSignal = await reqSignal(variable, year)
                let resultHorizon = await convertHorizon(resultSignal)
                let resultFilter = await filterHorizonByYear(resultHorizon, year);
                renderValueMonth(resultFilter)
            }

            // Get Result Month
            async function getResultMonth() {
                let variable = $('#selectVariable').val()
                let year = $('#selectYear').val()
                let resultSignal = await reqSignal(variable, year)
                let resultHorizon = await convertHorizon(resultSignal)
                let resultFilter = await filterResultMonthnByYear(resultHorizon);
                renderResultMonth(resultFilter)
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

            async function getRangkumanYear(params) {
                let variable = $('#selectVariable').val()
                let year = $('#selectYear').val()
                let resultSignal = await reqSignal(variable, year)
                let resultHorizon = await convertHorizon(resultSignal)
                let resultFilter = await filterRangkumanMonthnByYear(resultHorizon, year);
                renderRangkuman(resultFilter)
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
                        data[i].nilaiMonth24_2 = data[i].nilaiMonth12_1 ** 2
                        result[i] = data[i]
                    }
                }
                return result
            }

            async function filterHorizonByYear(data, year){
                let result = []
                data.forEach(el => {
                    if (el.tahun == year) {
                        result.push(el)
                    }
                })

                return result
            }

            // hitung horizon
            async function countHorizon() {
                let variable = $('#selectVariable').val()
                let year = $('#selectYear').val()
                let resultSignal = await reqSignal(variable, year)
                let resultHorizon = await convertHorizon(resultSignal)
                let resultFilter = await filterHorizonByYear(resultHorizon, year);
                renderHorizon(resultFilter)
            }

            // sorry for ugly code
            async function filterResultMonthnByYear(data) {
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
                    
                    tempSumSignalSMonth1 = data[i].signal + tempSumSignalSMonth1
                    tempSumSignalCMonth1 = data[i].signal_crisis + tempSumSignalCMonth1
                    tempSumSignalSMonth3 = data[i].signal + tempSumSignalSMonth3
                    tempSumSignalCMonth3 = data[i].signal_crisis + tempSumSignalCMonth3
                    tempSumSignalSMonth6 = data[i].signal + tempSumSignalSMonth6
                    tempSumSignalCMonth6 = data[i].signal_crisis + tempSumSignalCMonth6
                    tempSumSignalSMonth12 = data[i].signal + tempSumSignalSMonth12
                    tempSumSignalCMonth12 = data[i].signal_crisis + tempSumSignalCMonth12
                    tempSumSignalSMonth24 = data[i].signal + tempSumSignalSMonth24
                    tempSumSignalCMonth24 = data[i].signal_crisis + tempSumSignalCMonth24
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
                
                let result = [
                    [
                        [
                            'Sigma',
                            jumlah_month1 == 0 ? 'N/A' :  sigmaMonth1
                        ],
                        [
                            'Sigma',
                            jumlah_month3 == 0 ? 'N/A' :  sigmaMonth3
                        ],
                        [
                            'Sigma',
                            jumlah_month6 == 0 ? 'N/A' :  sigmaMonth6
                        ],
                        [
                            'Sigma',
                            jumlah_month12 == 0 ? 'N/A' :  sigmaMonth12
                        ],
                        [
                            'Sigma',
                            jumlah_month24 == 0 ? 'N/A' :  sigmaMonth24
                        ]
                    ],
                    [
                        [
                            'QPS',
                            jumlah_month1 == 0 ? 'N/A' : ((1 / jumlah_month1) * sigmaMonth1)
                        ],
                        [
                            'QPS',
                            jumlah_month3 == 0 ? 'N/A' : ((1 / jumlah_month3) * sigmaMonth3)
                        ],
                        [
                            'QPS',
                            jumlah_month6 == 0 ? 'N/A' : ((1 / jumlah_month6) * sigmaMonth6)
                        ],
                        [
                            'QPS',
                            jumlah_month12 == 0 ? 'N/A' : ((1 / jumlah_month12) * sigmaMonth12)
                        ],
                        [
                            'QPS',
                            jumlah_month24 == 0 ? 'N/A' : ((1 / jumlah_month24) * sigmaMonth24)
                        ]
                    ],
                    [
                        [
                            'Average R',
                            jumlah_month1 === 0 ? 'N/A' : averageR_month1
                        ],
                        [
                            'Average R',
                            jumlah_month3 === 0 ? 'N/A' : averageR_month3
                        ],
                        [
                            'Average R',
                            jumlah_month6 === 0 ? 'N/A' : averageR_month6
                        ],
                        [
                            'Average R',
                            jumlah_month12 === 0 ? 'N/A' : averageR_month12
                        ],
                        [
                            'Average R',
                            jumlah_month24 === 0 ? 'N/A' : averageR_month24
                        ]
                    ],
                    [
                        [
                            'Average P',
                            jumlah_month1 == 0 ? 'N/A' : averageP_month1
                        ],
                        [
                            'Average P',
                            jumlah_month3 == 0 ? 'N/A' : averageP_month3
                        ],
                        [
                            'Average P',
                            jumlah_month6 == 0 ? 'N/A' : averageP_month6
                        ],
                        [
                            'Average P',
                            jumlah_month12 == 0 ? 'N/A' : averageP_month12
                        ],
                        [
                            'Average P',
                            jumlah_month24 == 0 ? 'N/A' : averageP_month24
                        ]
                    ],
                    [
                        [
                            'GSB',
                            jumlah_month1 == 0 ? 'N/A' : (2 * ((averageP_month1 - averageR_month1) ** 2))
                        ],
                        [
                            'GSB',
                            jumlah_month3 == 0 ? 'N/A' : (2 * ((averageP_month3 - averageR_month3) ** 2))
                        ],
                        [
                            'GSB',
                            jumlah_month6 == 0 ? 'N/A' : (2 * ((averageP_month6 - averageR_month6) ** 2))
                        ],
                        [
                            'GSB',
                            jumlah_month12 == 0 ? 'N/A' : (2 * ((averageP_month12 - averageR_month12) ** 2))
                        ],
                        [
                            'GSB',
                            jumlah_month24 == 0 ? 'N/A' : (2 * ((averageP_month24 - averageR_month24) ** 2))
                        ]
                    ]
                ]
                return result
            }

            // sorry for ugly code
            async function filterRangkumanMonthnByYear(data, year) {
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
                    
                    tempSumSignalSMonth1 = data[i].signal + tempSumSignalSMonth1
                    tempSumSignalCMonth1 = data[i].signal_crisis + tempSumSignalCMonth1
                    tempSumSignalSMonth3 = data[i].signal + tempSumSignalSMonth3
                    tempSumSignalCMonth3 = data[i].signal_crisis + tempSumSignalCMonth3
                    tempSumSignalSMonth6 = data[i].signal + tempSumSignalSMonth6
                    tempSumSignalCMonth6 = data[i].signal_crisis + tempSumSignalCMonth6
                    tempSumSignalSMonth12 = data[i].signal + tempSumSignalSMonth12
                    tempSumSignalCMonth12 = data[i].signal_crisis + tempSumSignalCMonth12
                    tempSumSignalSMonth24 = data[i].signal + tempSumSignalSMonth24
                    tempSumSignalCMonth24 = data[i].signal_crisis + tempSumSignalCMonth24
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

                result [0] = []
                result[0][0] = '<strong>1 Month</strong>'
                result[0][1] = jumlah_month1 == 0 ? 'N/A' :  sumA_month1
                result[0][2] = jumlah_month1 == 0 ? 'N/A' :  sumB_month1
                result[0][3] = jumlah_month1 == 0 ? 'N/A' :  sumC_month1
                result[0][4] = jumlah_month1 == 0 ? 'N/A' :  sumD_month1
                result[0][5] = jumlah_month1 == 0 ? 'N/A' : jumlah_month1
                result[0][6] = '0.5'
                result[0][7] = jumlah_month1 == 0 ? 'N/A' :  ((sumA_month1 + sumD_month1) / jumlah_month1)
                result[0][8] = jumlah_month1 == 0 ? 'N/A' :  Object.is(NaN,((sumA_month1 / (sumA_month1 + sumC_month1)))) ? 0 : (sumA_month1 / (sumA_month1 + sumC_month1))
                result[0][9] = jumlah_month1 == 0 ? 'N/A' :  Object.is(NaN,((sumB_month1 / (sumB_month1 + sumD_month1))))  ? 0 : (sumB_month1 / (sumB_month1 + sumD_month1))
                result[0][10] = jumlah_month1 == 0 ? 'N/A' :  0.5 * result[0][7] * result[0][8]
                result[0][11] = jumlah_month1 == 0 ? 'N/A' :  (((1-0.5) * (1 - result[0][7])) * result[0][9])
                result[0][12] = jumlah_month1 == 0 ? 'N/A' :  result[0][10] + result[0][11]
                result[0][13] = jumlah_month1 == 0 ? 'N/A' :  ((1 / jumlah_month1) * sigmaMonth1)
                result[0][14] = jumlah_month1 == 0 ? 'N/A' :  (2 * ((averageP_month1 - averageR_month1) ** 2))
                result[0][15] = jumlah_month1 == 0 ? 'N/A' :  Object.is(NaN,(sumC_month1 / (sumC_month1 + sumD_month1))) ? 0 : (sumC_month1 / (sumC_month1 + sumD_month1))
                result[0][16] = jumlah_month1 == 0 ? 'N/A' :  Object.is(NaN,(sumB_month1 / (sumB_month1 + sumD_month1))) ? 0 : (sumB_month1 / (sumB_month1 + sumD_month1))
                result[0][17] = jumlah_month1 == 0 ? 'N/A' :  1 - result[0][12]

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
        })
    </script>
@endpush

@push('styles')
    <style>
        /* The heart of the matter */
          
        .horizontal-scrollable > table {
            overflow-x: auto;
            white-space: nowrap;
        }
          
        .horizontal-scrollable > table {
            display: inline-block;
            float: none;
        }
    </style>
@endpush
