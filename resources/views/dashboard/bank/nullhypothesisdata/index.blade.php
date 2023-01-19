@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Setting Treshold</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Setting Treshold</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <select
                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[120px] p-2.5">
                <option>Hypothesis</option>
            </select>
            <a id="addNew" href="{{ route('dashboard.bank.hypothesysdata.create') }}"
                class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm px-5 py-2.5"><i
                    class="fa-solid fa-plus"></i> Add New</a>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">Null Hypothesis</th>
                        <th scope="col" class="py-3 px-6">Obs</th>
                        <th scope="col" class="py-3 px-6">F-Statistic</th>
                        <th scope="col" class="py-3 px-6">Prob</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- <script>
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
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">${data[0]}</td>
                            <td class="py-4 px-6">${data[1]}</td>
                            <td class="py-4 px-6">${data[2]}</td>
                            <td class="py-4 px-6">${data[3]}</td>
                            <td class="py-4 px-6">${data[4]}</td>
                            <td class="py-4 px-6 flex flex-row gap-2 items-center justify-center">
                                <a href="/dashboard/bank/data/edit/${data[5]}/${data[6]}" class="py-0.5 px-2 bg-ds-yellow/20 text-ds-yellow rounded-lg cursor-pointer"><i class="fa-solid fa-pen"></i> Edit</a>
                                <button type="button" class="py-0.5 px-2 bg-ds-red/20 text-ds-red rounded-lg cursor-pointer" onclick="deleteData(${data[5]}, ${data[6]})">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                            </td>
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
                        url: '{{ route('dashboard.bank.data.getByYear') }}',
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

            /**
             * Modal Confirm Delete
             */
            window.deleteData = deleteData
            window.modalConfirmClose = modalConfirmClose

            function deleteData(tahun, bulan) {
                $('#modalTahun').val(tahun)
                $('#modalBulan').val(bulan)
                $('#modalText').html(`<span class="text-ds-red">"${months()[bulan - 1]} ${tahun}"</span>`)
                modal(document.getElementById('modalConfirm'), null, 1)
            }

            function modalConfirmClose() {
                modal(document.getElementById('modalConfirm'), null, 0)
            }

            $('#formDelete').submit(async function(e) {
                e.preventDefault()
                loadingButton(true, '#formSubmit', '')

                try {
                    const form = $(e.target);

                    const post = await axios({
                        method: 'post',
                        url: form.attr("action"),
                        headers: {},
                        data: form.serialize()
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

                this.reset()
                getByYear($('#selectYears').val())
                modalConfirmClose()
                loadingButton(false, '#formSubmit', 'Delete')
            })

        })
    </script> --}}
@endpush
