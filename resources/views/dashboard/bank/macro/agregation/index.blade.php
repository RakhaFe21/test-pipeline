@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Index Agregation</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Macro, Data, Index Agregation</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <select id="selectYears" class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[100px] p-2.5"></select>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead id="thead" class="text-xs uppercase bg-gray-200">

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

            let arr_composite = @json($arr_composite);
            let weight = {!! json_encode($weight) !!}
            let tahun = {!! json_encode($tahun) !!}
            let bulan = {!! json_encode($bulan) !!}
            let data = {!! json_encode($data) !!}

            let dataComposite = []

            years(tahun)
            setHeader(weight, tahun, bulan, data)

            /**
             * Set list years
             */
            function years(data) {
                Object.keys(data).forEach((key, index) => {
                    $('#selectYears').append(`<option value="${data[key].tahun}">${data[key].tahun}</option>`)
                })
            }

            /**
             * Get Months
             */
            function months() {
                let result = []
                let i = 0
                while (i < 12) {
                    let data = moment().month(i).locale('en').format('MMMM')
                    result.push(data)
                    i++
                }
                return result
            }

            function setHeader(weight, tahun, bulan, data) {
                const weightArr = []
                const basedArr = []

                Object.keys(weight).forEach((key, index) => {
                    weightArr.push(weight[key].weight)
                    basedArr.push(weight[key].based_year)
                })

                $('#thead').html('')
                $('#thead').append(`
                    <tr>
                        <td scope="col" class="py-3 px-6">Weight</td>
                        <td scope="col" class="py-3 px-6">${weightArr[0]}</td>
                        <td scope="col" class="py-3 px-6">${weightArr[1]}</td>
                        <td scope="col" class="py-3 px-6">${weightArr[2]}</td>
                        <td scope="col" class="py-3 px-6">${weightArr[3]}</td>
                        <th scope="col" class="py-3 px-6" rowspan="3">COMPOSITE INDEX</th>
                    </tr>
                    <tr>
                        <td scope="col" class="py-3 px-6">Base</td>
                        <td scope="col" class="py-3 px-6">${basedArr[0]}</td>
                        <td scope="col" class="py-3 px-6">${basedArr[1]}</td>
                        <td scope="col" class="py-3 px-6">${basedArr[2]}</td>
                        <td scope="col" class="py-3 px-6">${basedArr[3]}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="py-3 px-6">MONTH</th>
                        <th scope="col" class="py-3 px-6">IGDP</th>
                        <th scope="col" class="py-3 px-6">IINF</th>
                        <th scope="col" class="py-3 px-6">IER</th>
                        <th scope="col" class="py-3 px-6">IJII</th>
                    </tr>
                `)

                var j = 0
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
                                    obj.push(d.bulan)
                                }
                                obj.push(d.value_index)
                                if (count == 4) {
                                    let composite = arr_composite[j]
                                    console.log(composite);
                                    obj.push(parseFloat(composite.toFixed(3)))
                                }
                                count++
                            }
                        }
                        if (bulan != 0) {
                            dataComposite.push(obj)
                            j++
                        }
                    }
                }

                const selectYears = $('#selectYears').val()

                $('#tbody').html('')
                Object.keys(dataComposite).forEach((key, index) => {
                    if (dataComposite[key][0] == selectYears) {
                        $('#tbody').append(`
                            <tr class="bg-white border-b">
                                <td class="py-4 px-6">${months()[dataComposite[key][1] - 1]}</td>
                                <td class="py-4 px-6">${dataComposite[key][2]}</td>
                                <td class="py-4 px-6">${dataComposite[key][3]}</td>
                                <td class="py-4 px-6">${dataComposite[key][4]}</td>
                                <td class="py-4 px-6">${dataComposite[key][5]}</td>
                                <td class="py-4 px-6">${dataComposite[key][6]}</td>
                            </tr>
                        `)
                    }
                })

                setTimeout(function() {
                    // insert(dataComposite)
                }, 1000)
            }

            /**
             * Year Change
             */
            $('#selectYears').on('change', async function() {

                const selectYears = $(this).val()

                $('#tbody').html('')
                Object.keys(dataComposite).forEach((key, index) => {
                    if (dataComposite[key][0] == selectYears) {
                        $('#tbody').append(`
                            <tr class="bg-white border-b">
                                <td class="py-4 px-6">${months()[dataComposite[key][1] - 1]}</td>
                                <td class="py-4 px-6">${dataComposite[key][2]}</td>
                                <td class="py-4 px-6">${dataComposite[key][3]}</td>
                                <td class="py-4 px-6">${dataComposite[key][4]}</td>
                                <td class="py-4 px-6">${dataComposite[key][5]}</td>
                                <td class="py-4 px-6">${dataComposite[key][6]}</td>
                            </tr>
                        `)
                    }
                })
            })


        })
    </script>
@endpush
