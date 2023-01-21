@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Factor Analysis-AHP</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Factor Analysis-AHP</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <select id="selectTabs"
                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block p-2.5 pr-10"></select>
        </div>

        <div id="tab1" class="">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">VARIABLES</th>
                            <th scope="col" class="py-3 px-6">INPF</th>
                            <th scope="col" class="py-3 px-6">ICAR</th>
                            <th scope="col" class="py-3 px-6">IIPR</th>
                            <th scope="col" class="py-3 px-6">IFDR</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">Rank</th>
                            <th scope="col" class="py-3 px-6">Weight</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRank">

                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab2" class="hidden">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">VARIABLES</th>
                            <th scope="col" class="py-3 px-6">INPF</th>
                            <th scope="col" class="py-3 px-6">ICAR</th>
                            <th scope="col" class="py-3 px-6">IIPR</th>
                            <th scope="col" class="py-3 px-6">IFDR</th>
                            <th scope="col" class="py-3 px-6">CRITERIA</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCriteria">

                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab3" class="hidden">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center">
                    <thead id="theadCriteriaWeight" class="text-xs uppercase bg-gray-200">

                    </thead>
                    <tbody id="tbodyCriteriaWeight">

                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">Weighted Sum Value</th>
                            <th scope="col" class="py-3 px-6">Ceriteria Weighted</th>
                            <th scope="col" class="py-3 px-6">Ratio</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyWeightedSum">

                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                <table class="w-full text-sm text-left text-center">
                    <thead id="theadCriteriaWeight" class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="" colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody id="tbodyLamda">

                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab4" class="hidden">
            <img src="{{ asset('img/fundamental-scale.png') }}" alt="">
        </div>
        <div id="tab5" class="hidden">
            <img src="{{ asset('img/random-index.png') }}" alt="">
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const weight = {!! json_encode($weight) !!}
            const tahun = {!! json_encode($tahun) !!}
            const bulan = {!! json_encode($bulan) !!}
            const data = {!! json_encode($data) !!}

            const nilai = [1.00, 3.00, 5.00, 7.00]

            let rank = []
            Object.keys(weight).forEach((key, index) => {
                let map = new Map()
                map.set('id', weight[key].id)
                map.set('nama_variable', weight[key].nama_variable)
                map.set('weight', weight[key].weight)
                map.set('rank', parseInt(key) + 1)
                map.set('nilai', nilai[key].toFixed(2))
                rank.push(Object.fromEntries(map))
            })

            let rankSorted = rank.sort((a, b) => {
                if (a.id < b.id) {
                    return -1
                }
            })

            const variable = ['NPF', 'CAR', 'IPR', 'FDR']
            let npf = []
            let car = []
            let ipr = []
            let fdr = []

            Object.keys(rankSorted).forEach((key, index) => {

                Object.keys(rankSorted).forEach((keyRank, indexRank) => {

                    let nilaiMatrix = 0
                    let getRank = Math.abs(rankSorted[key].rank - rankSorted[keyRank].rank)

                    if (rankSorted[keyRank].rank >= rankSorted[key].rank) {
                        if (parseFloat(getRank) == 0) {
                            nilaiMatrix = nilai[0]
                        } else if (parseFloat(getRank) == 1) {
                            nilaiMatrix = nilai[1]
                        } else if (parseFloat(getRank) == 2) {
                            nilaiMatrix = nilai[2]
                        } else {
                            nilaiMatrix = nilai[3]
                        }
                    } else {
                        if (parseFloat(getRank) == 0) {
                            nilaiMatrix = 1 / parseFloat(nilai[0])
                        } else if (parseFloat(getRank) == 1) {
                            nilaiMatrix = 1 / parseFloat(nilai[1])
                        } else if (parseFloat(getRank) == 2) {
                            nilaiMatrix = 1 / parseFloat(nilai[2])
                        } else {
                            nilaiMatrix = 1 / parseFloat(nilai[3])
                        }
                    }

                    if (keyRank == 0) {
                        npf.push(parseFloat(nilaiMatrix).toFixed(2))
                    } else if (keyRank == 1) {
                        car.push(parseFloat(nilaiMatrix).toFixed(2))
                    } else if (keyRank == 2) {
                        ipr.push(parseFloat(nilaiMatrix).toFixed(2))
                    } else {
                        fdr.push(parseFloat(nilaiMatrix).toFixed(2))
                    }
                })
            })

            let varTd = ''
            let npfTd = ''
            let carTd = ''
            let iprTd = ''
            let fdrTd = ''
            $('#tbody').html('')
            Object.keys(variable).forEach((key, index) => {

                varTd = `<td class="py-4 px-6">I${variable[key]}</td>`

                if (parseFloat(npf[key]) == parseFloat(nilai[0])) {
                    npfTd = `<td class="py-4 px-6 text-ds-yellow font-medium">${npf[key]}</td>`
                } else {
                    npfTd = `<td class="py-4 px-6">${npf[key]}</td>`
                }
                if (parseFloat(car[key]) == parseFloat(nilai[0])) {
                    carTd = `<td class="py-4 px-6 text-ds-yellow font-medium">${car[key]}</td>`
                } else {
                    carTd = `<td class="py-4 px-6">${car[key]}</td>`
                }
                if (parseFloat(ipr[key]) == parseFloat(nilai[0])) {
                    iprTd = `<td class="py-4 px-6 text-ds-yellow font-medium">${ipr[key]}</td>`
                } else {
                    iprTd = `<td class="py-4 px-6">${ipr[key]}</td>`
                }
                if (parseFloat(fdr[key]) == parseFloat(nilai[0])) {
                    fdrTd = `<td class="py-4 px-6 text-ds-yellow font-medium">${fdr[key]}</td>`
                } else {
                    fdrTd = `<td class="py-4 px-6">${fdr[key]}</td>`
                }

                $('#tbody').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        ${varTd}
                        ${npfTd}
                        ${carTd}
                        ${iprTd}
                        ${fdrTd}
                    </tr>
                `)

                $('#tbodyRank').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">${variable[key]}</td>
                        <td class="py-4 px-6">${rank[key].weight}</td>
                    </tr>
                `)
            })

            let total = [sum(npf), sum(car), sum(ipr), sum(fdr)]
            $('#tbody').append(`
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">TOTAL</td>
                    <td class="py-4 px-6">${total[0].toFixed(2)}</td>
                    <td class="py-4 px-6">${total[1].toFixed(2)}</td>
                    <td class="py-4 px-6">${total[2].toFixed(2)}</td>
                    <td class="py-4 px-6">${total[3].toFixed(2)}</td>
                </tr>
            `)

            let npfNormalized = []
            let carNormalized = []
            let iprNormalized = []
            let fdrNormalized = []
            let criteriaNormalized = []
            Object.keys(variable).forEach((key, index) => {
                npfNormalized.push(parseFloat(npf[key]) / parseFloat(total[0]))
                carNormalized.push(parseFloat(car[key]) / parseFloat(total[1]))
                iprNormalized.push(parseFloat(ipr[key]) / parseFloat(total[2]))
                fdrNormalized.push(parseFloat(fdr[key]) / parseFloat(total[3]))

                criteriaNormalized.push((sum([npfNormalized[key].toFixed(2), carNormalized[key].toFixed(2),
                    iprNormalized[key].toFixed(2), fdrNormalized[key].toFixed(2)
                ]) / 4))
            })

            $('#tbodyCriteria').html('')
            Object.keys(variable).forEach((key, index) => {
                $('#tbodyCriteria').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">I${variable[key]}</td>
                        <td class="py-4 px-6 text-ds-yellow font-medium">${npfNormalized[key].toFixed(2)}</td>
                        <td class="py-4 px-6 text-ds-yellow font-medium">${carNormalized[key].toFixed(2)}</td>
                        <td class="py-4 px-6 text-ds-yellow font-medium">${iprNormalized[key].toFixed(2)}</td>
                        <td class="py-4 px-6 text-ds-yellow font-medium">${fdrNormalized[key].toFixed(2)}</td>
                        <td class="py-4 px-6">${criteriaNormalized[key].toFixed(2)}</td>
                    </tr>
                `)
            })

            let totalNormalized = [sum(npfNormalized), sum(carNormalized), sum(iprNormalized), sum(fdrNormalized),
                sum(criteriaNormalized)
            ]
            $('#tbodyCriteria').append(`
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">TOTAL</td>
                    <td class="py-4 px-6">${totalNormalized[0].toFixed(2)}</td>
                    <td class="py-4 px-6">${totalNormalized[1].toFixed(2)}</td>
                    <td class="py-4 px-6">${totalNormalized[2].toFixed(2)}</td>
                    <td class="py-4 px-6">${totalNormalized[3].toFixed(2)}</td>
                    <td class="py-4 px-6">${totalNormalized[4].toFixed(2)}</td>
                </tr>
            `)

            let npfRatio = []
            let carRatio = []
            let iprRatio = []
            let fdrRatio = []
            let weightedSumValue = []
            let ratio = []
            Object.keys(variable).forEach((key, index) => {
                npfRatio.push(parseFloat(npf[key]) * parseFloat(criteriaNormalized[0]))
                carRatio.push(parseFloat(car[key]) * parseFloat(criteriaNormalized[1]))
                iprRatio.push(parseFloat(ipr[key]) * parseFloat(criteriaNormalized[2]))
                fdrRatio.push(parseFloat(fdr[key]) * parseFloat(criteriaNormalized[3]))

                weightedSumValue.push(sum([npfRatio[key].toFixed(2), carRatio[key].toFixed(2), iprRatio[key]
                    .toFixed(2), fdrRatio[key].toFixed(2)
                ]))
            })

            $('#theadCriteriaWeight').html('')
            $('#theadCriteriaWeight').append(`
                <tr>
                    <th scope="col" class="py-3 px-6">CRITERIA WEIGHT</th>
                    <th scope="col" class="py-3 px-6">${criteriaNormalized[0].toFixed(2)}</th>
                    <th scope="col" class="py-3 px-6">${criteriaNormalized[1].toFixed(2)}</th>
                    <th scope="col" class="py-3 px-6">${criteriaNormalized[2].toFixed(2)}</th>
                    <th scope="col" class="py-3 px-6">${criteriaNormalized[3].toFixed(2)}</th>
                </tr>
                <tr>
                    <th scope="col" class="py-3 px-6">VARIABLES</th>
                    <th scope="col" class="py-3 px-6">INPF</th>
                    <th scope="col" class="py-3 px-6">ICAR</th>
                    <th scope="col" class="py-3 px-6">IIPR</th>
                    <th scope="col" class="py-3 px-6">IFDR</th>
                </tr>
            `)

            $('#tbodyCriteriaWeight').html('')
            Object.keys(variable).forEach((key, index) => {
                $('#tbodyCriteriaWeight').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">I${variable[key]}</td>
                        <td class="py-4 px-6">${npfRatio[key].toFixed(2)}</td>
                        <td class="py-4 px-6">${carRatio[key].toFixed(2)}</td>
                        <td class="py-4 px-6">${iprRatio[key].toFixed(2)}</td>
                        <td class="py-4 px-6">${fdrRatio[key].toFixed(2)}</td>
                    </tr>
                `)
            })

            $('#tbodyWeightedSum').html('')
            Object.keys(variable).forEach((key, index) => {
                ratio.push(weightedSumValue[key] / criteriaNormalized[key])
                $('#tbodyWeightedSum').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">${weightedSumValue[key].toFixed(2)}</td>
                        <td class="py-4 px-6">${criteriaNormalized[key].toFixed(2)}</td>
                        <td class="py-4 px-6">${ratio[key].toFixed(2)}</td>
                    </tr>
                `)
            })

            let lamdaMax = (sum(ratio)) / 4
            let ci = (lamdaMax.toFixed(2) - 4) / (4 - 1)
            let randomIndex = 0.9
            let consistencyRatio = ci.toFixed(2) / randomIndex.toFixed(2)
            let percent = consistencyRatio * 100

            $('#tbodyLamda').html('')
            $('#tbodyLamda').append(`
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">Lamnda Max</td>
                    <td class="py-4 px-6">${lamdaMax.toFixed(2)}</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">CI</td>
                    <td class="py-4 px-6">${ci.toFixed(2)}</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">Random Index</td>
                    <td class="py-4 px-6">${randomIndex}</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">Consistency Ration</td>
                    <td class="py-4 px-6">${consistencyRatio.toFixed(2)}</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">%</td>
                    <td class="py-4 px-6">${percent.toFixed(0)}%</td>
                </tr>
            `)

            /**
             * Show Tabs
             */
            const tabs = [{
                    'id': 'tab1',
                    'name': 'Step 1-Matrix Analysis of Islamic Bangking Variables'
                },
                {
                    'id': 'tab2',
                    'name': 'Step 2-Normalized'
                },
                {
                    'id': 'tab3',
                    'name': 'Step 3-CHY Consistency'
                },
                {
                    'id': 'tab4',
                    'name': 'Step 4-Fundamental Scale'
                },
                {
                    'id': 'tab5',
                    'name': 'Step 5-Random Index RI'
                }
            ]

            Object.keys(tabs).forEach((key, index) => {
                $('#selectTabs').append(`<option value="${tabs[key].id}">${tabs[key].name}</option>`)
            })

            $('#selectTabs').on('change', function() {
                let id = $(this).val()
                Object.keys(tabs).forEach((key, index) => {
                    if (id == tabs[key].id) {
                        $('#' + id).removeClass('hidden')
                    } else {
                        $('#' + tabs[key].id).addClass('hidden')
                    }
                })
            })

            /**
             * Insert
             */
            setTimeout(function() {
                insert(consistencyRatio)
            }, 1000)

            async function insert(consistencyRatio) {
                try {
                    const post = await axios({
                        method: 'post',
                        url: '{{ route('dashboard.bank.ibri.factorAnalysis.store') }}',
                        headers: {},
                        data: {
                            consistency_ratio: consistencyRatio.toFixed(3)
                        }
                    })

                    const data = post.data

                    if (data.code === 200) {
                        toastr.success(data.message)
                    } else {
                        toastr.warning(data.message)
                    }
                } catch (error) {
                    toastr.error(error.message)
                }
            }

            /**
             * Set list years
             */
            function years(data) {
                Object.keys(data).forEach((key, index) => {
                    $('#selectYears').append(
                        `<option value="${data[key].tahun}">${data[key].tahun}</option>`)
                })
            }

            /**
             * Get Months
             */
            function months() {
                let result = []
                let i = 0
                while (i < 12) {
                    let data = moment().month(i).locale('{{ config('app.locale') }}').format('MMMM')
                    result.push(data)
                    i++
                }
                return result
            }

            /**
             * Sum
             */
            function sum(arr) {
                return mathjs.sum(arr)
            }

        })
    </script>
@endpush
