@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Upper Threshold</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Macro, Data, EWS - Out sample Mode, Upper Threshold</span>
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

                </thead>
                <tbody id="bodyHorizonTable">

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
                    "title": "Rangkuman Upper Treshold"
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
                let variable = $('#selectVariable').val()
                let year = $('#selectYear').val()
                getSignal(variable, year)
            })

            $('#selectYear').on('change', function () {
                let variable = $('#selectVariable').val()
                let year = $('#selectYear').val()
                getSignal(variable, year)
            })

            $('#selectTable').on('change', function() {
                let id = $('#selectTable').val()
                Object.keys(table).forEach((key, index) => {
                    if(id == table[key].table) {
                        $('#' + id).removeClass('hidden')
                    } else {
                        $('#' + table[key].table).addClass('hidden')
                    }
                })
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

                    let signalC = (fData[key].value_index > fData[key].average)?1:0

                    $('#bodySCTable').append(`
                            <tr>
                                <td class="border border-slate-300 py-4 px-6">` + months(fData[key].bulan) + `</td>
                                <td class="border border-slate-300 py-4 px-6">${fData[key].signal}</td>
                                <td class="border border-slate-300 py-4 px-6">${signalC}</td>
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
                        url: '{{ route('dashboard.bank.ibri.ews.signal') }}',
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
        })
    </script>
@endpush
