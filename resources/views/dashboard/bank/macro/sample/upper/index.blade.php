@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Upper Threshold</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Macro, Step Macro, HP - In sample Model, Upper Threshold</span>
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
                    <option value="${tahun[key].tahun}-${tahun[key].variable_masters_id}-${tahun[key].nama_variable.toUpperCase()}">${tahun[key].tahun} ${tahun[key].nama_variable === 'ci' ? tahun[key].nama_variable.toUpperCase() : 'I'+tahun[key].nama_variable.toUpperCase()} HP</option>
                `)
            })

            getData($('#selectPeriod').val())

            $('#selectPeriod').on('change', async function() {
                getData($('#selectPeriod').val())
            })

            function dataObject(data, filter, average, varName)
            {
                let f = filter.split("-")
                let tahun = f[0]
                let variable = f[1]

                let fData = []
                for (let i = 0; i < data.length; i++) {
                    if(data[i].tahun == tahun) {
                        fData.push(data[i])
                    }
                }
                renderTable(data, fData, average, varName)
            }

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

            function renderTable(data, fData, average, varName) {
                $('#tbodyUpper').html('')
                let totalSignal = 0
                Object.keys(data).forEach((key, index) => {
                    totalSignal += (data[key].hp > average)?1:0
                })
                if (varName == 'CI') {
                    varName = 'CI'
                } else{
                    varName = 'I'+varName
                }

                $('#headerUpper').html(`
                        <tr>
                            <th scope="col" class="py-3 px-6">YEAR</th>
                            <th scope="col" class="py-3 px-6">MONTHS</th>
                            <th scope="col" class="py-3 px-6">${varName}</th>
                            <th scope="col" class="py-3 px-6">${varName} - HP</th>
                            <th scope="col" class="py-3 px-6">AVERAGE</th>
                            <th scope="col" class="py-3 px-6">SIGNAL</th>
                        <tr>
                    `)

                Object.keys(fData).forEach((key, index) => {
                    let first = true
                    let rowSpaned = ''
                    let signal = (fData[key].value_index > average)?1:0

                    if(index==0) {
                        rowSpaned = `<td rowspan="12" class="border border-slate-300 py-4 px-6">${fData[key].tahun}</td>`
                    } else {
                        rowSpaned = ''
                    }

                    $('#tbodyUpper').append(`
                            <tr>`+rowSpaned+`<td class="border border-slate-300 py-4 px-6">`+months(fData[key].bulan)+`</td>
                                <td class="border border-slate-300 py-4 px-6">${fData[key].value_index.toFixed(2)}</td>
                                <td class="border border-slate-300 py-4 px-6">${fData[key].hp.toFixed(2)}</td>
                                <td class="border border-slate-300 py-4 px-6">${average}</td>
                                <td class="border border-slate-300 py-4 px-6 ${signal == 0 ? 'text-red-500 text-bold' : ''}">${signal}</td>
                            </tr>
                        `)
                })

                $('#upperTresholdHeader').html(`
                        <tr>
                            <th scope="col" rowspan="6" class="py-3 px-6" align="right">TOTAL SIGNAL</th>
                            <th scope="col" class="py-3 px-6" align="right">${totalSignal}</th>
                        <tr>
                    `)
            }

            async function getData(filter) {
                try {
                    const filter = $('#selectPeriod').val()

                    const post = await axios({
                        method: 'get',
                        url: '{{ route('dashboard.bank.macro.sample.upper.data' , ['code' => \Route::current()->parameter('code')]) }}',
                        headers: {},
                        params: {
                            'periode': filter
                        }
                    })

                    const data = post.data

                    if (data.code === 200) {
                        //setTable(dataObject(data.bulan, data.data))
                        dataObject(data.data, filter, data.average, data.varName)
                        //console.log(data.upperData)
                    } else {
                        toastr.warning(data.message)
                    }
                } catch (error) {
                    toastr.error(error.message)
                }
            }

        })
    </script>
@endpush
