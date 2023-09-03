@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Setting Composite Index</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Integrasi Bank & Macro, Setting Composite Index</span>
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

            let tahun = {!! json_encode($tahun) !!}
            let bulan = {!! json_encode($bulan) !!}
            let data = {!! json_encode($data) !!}

            let dataComposite = []

            years(tahun)
            setHeader(tahun, bulan, data)

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

            function setHeader( tahun, bulan, data) {
                const basedArr = []


                $('#thead').html('')
                $('#thead').append(`
                    <tr>
                        <th scope="col" class="py-3 px-6">MONTH</th>
                        <th scope="col" class="py-3 px-6">Macroeconomic Vulnerabelity Index</th>
                        <th scope="col" class="py-3 px-6">Islamic Banking Composite Index</th>
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
                                <td class="py-4 px-6">${dataComposite[key][3]}</td>
                                <td class="py-4 px-6">${dataComposite[key][2]}</td>
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
                                <td class="py-4 px-6">${dataComposite[key][3]}</td>
                                <td class="py-4 px-6">${dataComposite[key][2]}</td>
                            </tr>
                        `)
                    }
                })
            })


        })
    </script>
@endpush
