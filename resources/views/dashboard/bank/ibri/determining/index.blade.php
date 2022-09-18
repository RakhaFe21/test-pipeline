@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Determining Weight</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Determining Weight</span>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6" rowspan="2">Years</th>
                        <th scope="col" class="py-3 px-6" colspan="4">PRSSURE</th>
                        <th scope="col" class="py-3 px-6" rowspan="2">TOTAL</th>
                    </tr>
                    <tr>
                        <th scope="col" class="py-3 px-6">VAR INPF</th>
                        <th scope="col" class="py-3 px-6">VAR ICAR</th>
                        <th scope="col" class="py-3 px-6">VAR IIPR</th>
                        <th scope="col" class="py-3 px-6">VAR IFDR</th>
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
                                obj.push(d.value_index)
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

                let dataVarsGroup = []
                let dataVars = []
                let npf = []
                let car = []
                let ipr = []
                let fdr = []
                let totalAverage = 0
                let totalWeight = 0

                Object.keys(tahun).forEach((keyTahun, indexTahun) => {

                    Object.keys(data).forEach((keyData, indexData) => {
                        if (tahun[keyTahun].tahun === data[keyData][0]) {
                            npf.push(data[keyData][1])
                            car.push(data[keyData][2])
                            ipr.push(data[keyData][3])
                            fdr.push(data[keyData][4])
                        }
                    })

                    dataVars.push(tahun[keyTahun].tahun)
                    dataVars.push(variance(npf).toFixed(3))
                    dataVars.push(variance(car).toFixed(3))
                    dataVars.push(variance(ipr).toFixed(3))
                    dataVars.push(variance(fdr).toFixed(3))
                    dataVarsGroup.push(dataVars)

                    dataVars = []
                    npf = []
                    car = []
                    ipr = []
                    fdr = []
                })

                Object.keys(dataVarsGroup).forEach((key, index) => {
                    npf.push(parseInt(dataVarsGroup[key][1]))
                    car.push(parseInt(dataVarsGroup[key][2]))
                    ipr.push(parseInt(dataVarsGroup[key][3]))
                    fdr.push(parseInt(dataVarsGroup[key][4]))
                })

                dataVars.push('Average')
                dataVars.push(average(npf).toFixed(3))
                dataVars.push(average(car).toFixed(3))
                dataVars.push(average(ipr).toFixed(3))
                dataVars.push(average(fdr).toFixed(3))
                totalAverage = sum([average(npf), average(car), average(ipr), average(fdr)])
                dataVars.push(totalAverage.toFixed(3))
                dataVarsGroup.push(dataVars)

                dataVars = []
                dataVars.push('Weight')
                dataVars.push((average(npf) / totalAverage).toFixed(3))
                dataVars.push((average(car) / totalAverage).toFixed(3))
                dataVars.push((average(ipr) / totalAverage).toFixed(3))
                dataVars.push((average(fdr) / totalAverage).toFixed(3))
                totalWeight = sum([(average(npf) / totalAverage), (average(car) / totalAverage), (average(ipr) / totalAverage), (average(fdr) / totalAverage)])
                dataVars.push(totalWeight.toFixed(3))
                dataVarsGroup.push(dataVars)

                $('#tbody').html('')
                Object.keys(dataVarsGroup).forEach((key, index) => {
                    let value = dataVarsGroup[key]

                    $('#tbody').append(`
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">${value[0]}</td>
                            <td class="py-4 px-6">${value[1]}</td>
                            <td class="py-4 px-6">${value[2]}</td>
                            <td class="py-4 px-6">${value[3]}</td>
                            <td class="py-4 px-6">${value[4]}</td>
                            <td class="py-4 px-6">${(value[5]) ? value[5] : ''}</td>
                        </tr>
                    `)
                })
            }

            function variance(arr) {
                return mathjs.variance(arr)
            }

            function average(arr) {
                return arr.reduce((a, b) => a + b, 0) / arr.length
            }

            function sum(arr) {
                return mathjs.sum(arr)
            }
        })
    </script>
@endpush
