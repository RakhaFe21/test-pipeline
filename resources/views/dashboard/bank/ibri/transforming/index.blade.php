@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Transforming into Index</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Transforming into Index</span>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">YEARS</th>
                        <th scope="col" class="py-3 px-6">NPF</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
                        <th scope="col" class="py-3 px-6">CAR</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
                        <th scope="col" class="py-3 px-6">IPR</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
                        <th scope="col" class="py-3 px-6">FDR</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
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

            const tahun = {!! json_encode($tahun) !!}
            const bulan = {!! json_encode($bulan) !!}
            const data = {!! json_encode($data) !!}

            function dataObject(tahun, bulan, data) {
                let arr = []
                for (let t of tahun) {
                    for (let b of bulan) {
                        let obj = []
                        let count = 1
                        let bulan = 0
                        for (let d of data) {
                            if (t.tahun === d.tahun && b.bulan === d.bulan) {
                                bulan = d.bulan
                                if (count == 1) {
                                    obj.push(d.tahun)
                                }
                                obj.push(d.value)
                                if (count == 4) {
                                    obj.push(d.bulan)
                                }
                                count++
                            }
                        }
                        if (bulan != 0) {
                            arr.push(obj)
                        }
                    }
                }
                return arr
            }

            dataDeviasi(tahun, bulan, dataObject(tahun, bulan, data))

            function dataDeviasi(tahun, bulan, data) {

                let dataStdevsGroup = []
                let dataStdevs = []
                let npf = []
                let car = []
                let ipr = []
                let fdr = []
                let npfMby = 0
                let carMby = 0
                let iprMby = 0
                let fdrMby = 0

                Object.keys(tahun).forEach((keyTahun, indexTahun) => {

                    Object.keys(data).forEach((keyData, indexData) => {
                        if (tahun[keyTahun].tahun === data[keyData][0]) {
                            npf.push(data[keyData][1])
                            car.push(data[keyData][2])
                            ipr.push(data[keyData][3])
                            fdr.push(data[keyData][4])
                        }
                    })

                    dataStdevs.push(tahun[keyTahun].tahun)

                    dataStdevs.push(stdevs(npf).toFixed(3))
                    dataStdevs.push(average(npf).toFixed(3))
                    dataStdevs.push(stdevs(car).toFixed(3))
                    dataStdevs.push(average(car).toFixed(3))
                    dataStdevs.push(stdevs(ipr).toFixed(3))
                    dataStdevs.push(average(ipr).toFixed(3))
                    dataStdevs.push(stdevs(fdr).toFixed(3))
                    dataStdevs.push(average(fdr).toFixed(3))

                    dataStdevsGroup.push(dataStdevs)

                    dataStdevs = []
                    npf = []
                    car = []
                    ipr = []
                    fdr = []
                })

                Object.keys(dataStdevsGroup).forEach((key, index) => {
                    npf.push(dataStdevsGroup[key][1])
                    car.push(dataStdevsGroup[key][3])
                    ipr.push(dataStdevsGroup[key][5])
                    fdr.push(dataStdevsGroup[key][7])
                })

                $('#tbody').html('')
                Object.keys(dataStdevsGroup).forEach((key, index) => {
                    let value = dataStdevsGroup[key]

                    let npfTd = ''
                    let carTd = ''
                    let iprTd = ''
                    let fdrTd = ''

                    if (String(value[1]) === String(min(npf))) {
                        npfMby = value[2]
                        npfTd = `<td class="py-4 px-6 text-ds-red font-bold">${value[1]}</td>`
                    } else {
                        npfTd = `<td class="py-4 px-6">${value[1]}</td>`
                    }

                    if (String(value[3]) === String(min(car))) {
                        carMby = value[4]
                        carTd = `<td class="py-4 px-6 text-ds-red font-bold">${value[3]}</td>`
                    } else {
                        carTd = `<td class="py-4 px-6">${value[3]}</td>`
                    }

                    if (String(value[5]) === String(min(ipr))) {
                        iprMby = value[6]
                        iprTd = `<td class="py-4 px-6 text-ds-red font-bold">${value[5]}</td>`
                    } else {
                        iprTd = `<td class="py-4 px-6">${value[5]}</td>`
                    }

                    if (String(value[7]) === String(min(fdr))) {
                        fdrMby = value[8]
                        fdrTd = `<td class="py-4 px-6 text-ds-red font-bold">${value[7]}</td>`
                    } else {
                        fdrTd = `<td class="py-4 px-6">${value[7]}</td>`
                    }

                    $('#tbody').append(`
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">${value[0]}</td>
                            ${npfTd}
                            <td class="py-4 px-6">${value[2]}</td>
                            ${carTd}
                            <td class="py-4 px-6">${value[4]}</td>
                            ${iprTd}
                            <td class="py-4 px-6">${value[6]}</td>
                            ${fdrTd}
                            <td class="py-4 px-6">${value[8]}</td>
                        </tr>
                    `)
                })

                let obj = []
                Object.keys(data).forEach((key, index) => {
                    let map = new Map()
                    map.set('tahun', data[key][0])
                    map.set('bulan', data[key][5])
                    map.set('npf', ((data[key][1] - npfMby) / min(npf)).toFixed(3))
                    map.set('car', ((data[key][2] - carMby) / min(car)).toFixed(3))
                    map.set('ipr', ((data[key][3] - iprMby) / min(ipr)).toFixed(3))
                    map.set('fdr', ((data[key][4] - fdrMby) / min(fdr)).toFixed(3))
                    obj.push(Object.fromEntries(map))
                })

                setTimeout(function() {
                    insert(obj)
                }, 1000)
            }

            async function insert(arr) {
                try {
                    const post = await axios({
                        method: 'post',
                        url: '{{ route('dashboard.bank.ibri.transforming.store') }}',
                        headers: {},
                        data: {
                            data: JSON.stringify(arr)
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

            function stdevs(arr, usePopulation = false) {
                const mean = arr.reduce((acc, val) => acc + val, 0) / arr.length
                return Math.sqrt(arr.reduce((acc, val) => acc.concat((val - mean) ** 2), []).reduce((acc, val) => acc + val, 0) / (arr.length - (usePopulation ? 0 : 1)))
            }

            function average(arr) {
                return arr.reduce((a, b) => a + b, 0) / arr.length
            }

            function min(arr) {
                return Math.min(...arr)
            }
        })
    </script>
@endpush
