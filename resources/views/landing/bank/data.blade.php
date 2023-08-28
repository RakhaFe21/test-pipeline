@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px] h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Data</h1>
        <p class="mb-5">{{ __('data.desc') }}</p>

        <select id="selectYears" class="bg-gray-50 border border-ld-green/50 mb-4 text-gray-900 text-sm rounded-lg focus:ring-ld-green/50 focus:border-ld-green/50 block w-[100px] p-2.5"></select>

        <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th class="p-4">MONTH</th>
                        <th class="p-4">NPF</th>
                        <th class="p-4">CAR</th>
                        <th class="p-4">IPR</th>
                        <th class="p-4">FDR</th>
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

            let tahun = {!! json_encode($tahun) !!}
            let bulan = {!! json_encode($bulan) !!}
            let data = {!! json_encode($data) !!}

            years(tahun)
            setTable(dataObject(bulan, data))

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
                    let data = moment().month(i).locale('{{ config('app.locale') }}').format('MMMM')
                    result.push(data)
                    i++
                }
                return result
            }

            /**
             * Get data object
             */
            function dataObject(bulan, data) {
                let arr = []
                for (let a of bulan) {
                    let obj = []
                    obj.push(months()[a.bulan - 1])

                    let count = 1
                    for (let b of data) {
                        if (a.bulan === b.bulan) {
                            obj.push(b.value)
                            if (count == 4) {
                                obj.push(b.tahun)
                                obj.push(b.bulan)
                            }
                            count++
                        }
                    }
                    arr.push(obj)
                }
                return arr
            }

            /**
             * Set data table
             */
            function setTable(obj) {
                $('#tbody').html('')
                Object.keys(obj).forEach((key, index) => {
                    let data = obj[key]
                    $('#tbody').append(`
                        <tr>
                            <td class="colspan-13 p-2"></td>
                        </tr>
                        <tr class="bg-ld-green/10 rounded-lg">
                            <td class="py-2">${data[0]}</td>
                            <td class="py-2">${data[1]}</td>
                            <td class="py-2">${data[2]}</td>
                            <td class="py-2">${(data[3]).toFixed(2)}</td>
                            <td class="py-2">${data[4]}</td>
                        </tr>
                    `)
                })
            }

            /**
             * Year Change
             */
            $('#selectYears').on('change', async function() {
                getByYear($('#selectYears').val())
            })

            async function getByYear(year) {
                try {
                    const year = $('#selectYears').val()

                    const post = await axios({
                        method: 'post',
                        url: '{{ route('bank.data.getByYear', ['locale' =>  \Route::current()->parameter('locale')]) }}',
                        headers: {},
                        data: {
                            'year': year
                        }
                    })

                    const data = post.data

                    if (data.code === 200) {
                        setTable(dataObject(data.bulan, data.data))
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
