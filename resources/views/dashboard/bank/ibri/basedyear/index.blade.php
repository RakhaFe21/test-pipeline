@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Selecting Based Year</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Selecting Based Years</span>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">Variables</th>
                        <th scope="col" class="py-3 px-6">Base Year</th>
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
                    dataStdevs.push(stdevs(car).toFixed(3))
                    dataStdevs.push(stdevs(ipr).toFixed(3))
                    dataStdevs.push(stdevs(fdr).toFixed(3))
                    dataStdevsGroup.push(dataStdevs)

                    dataStdevs = []
                    npf = []
                    car = []
                    ipr = []
                    fdr = []
                })

                Object.keys(dataStdevsGroup).forEach((key, index) => {
                    npf.push(dataStdevsGroup[key][1])
                    car.push(dataStdevsGroup[key][2])
                    ipr.push(dataStdevsGroup[key][3])
                    fdr.push(dataStdevsGroup[key][4])
                })

                let npfTd = ''
                let carTd = ''
                let iprTd = ''
                let fdrTd = ''

                $('#tbody').html('')
                Object.keys(dataStdevsGroup).forEach((key, index) => {
                    let value = dataStdevsGroup[key]

                    if (String(value[1]) === String(min(npf))) {
                        npfTd = value[0]
                    }
                    if (String(value[2]) === String(min(car))) {
                        carTd = value[0]
                    }
                    if (String(value[3]) === String(min(ipr))) {
                        iprTd = value[0]
                    }
                    if (String(value[4]) === String(min(fdr))) {
                        fdrTd = value[0]
                    }
                })

                $('#tbody').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">INPF</td>
                        <td class="py-4 px-6">${npfTd}</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">ICAR</td>
                        <td class="py-4 px-6">${carTd}</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">IIPR</td>
                        <td class="py-4 px-6">${iprTd}</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">IFDR</td>
                        <td class="py-4 px-6">${fdrTd}</td>
                    </tr>
                `)

                setTimeout(function() {
                    insert(npfTd, carTd, iprTd, fdrTd)
                }, 1000)
            }

            async function insert(npf, car, ipr, fdr) {
                try {
                    const post = await axios({
                        method: 'post',
                        url: '{{ route('dashboard.bank.ibri.basedYear.store') }}',
                        headers: {},
                        data: {
                            npf: npf,
                            car: car,
                            ipr: ipr,
                            fdr: fdr,
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
