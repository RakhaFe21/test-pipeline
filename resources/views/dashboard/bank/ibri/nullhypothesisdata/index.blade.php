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
                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[120px] p-2.5" id="selectTabs">
            </select>
            <a id="addNew" href="{{ route('dashboard.bank.hypothesysdata.create', ['code'  => \Route::current()->parameter('code')]) }}"
                class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm px-5 py-2.5"><i
                    class="fa-solid fa-plus"></i> Add New</a>
        </div>

        <div class="" id="tab1">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center border-collapse">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">Null Hypothesis</th>
                            <th scope="col" class="py-3 px-6">Obs</th>
                            <th scope="col" class="py-3 px-6">F-Statistic</th>
                            <th scope="col" class="py-3 px-6">Prob</th>
                            <th scope="col" class="py-3 px-6">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="hidden" id="tab2">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center border-collapse" id="table2">

                </table>
            </div>
        </div>
        <div class="hidden" id="tab3">
            <p class="mb-6 text-center text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Normalization of Direct Relation Matrix</p>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-6">
                <table class="w-full text-sm text-left text-center border-collapse" id="table3">

                </table>
            </div>

            <p class="mb-6 text-center text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">IDENTITY MATRIK 12X12 (I)</p>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-6">
                <table class="w-full text-sm text-left text-center border-collapse" id="table4">

                </table>
            </div>

            <p class="mb-6 text-center text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Matrix Identity (I)- Matrix Y</p>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-6">
                <table class="w-full text-sm text-left text-center border-collapse" id="table5">

                </table>
            </div>

            <p class="mb-6 text-center text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">INVERSE MATRIX OF I-Y</p>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-6">
                <table class="w-full text-sm text-left text-center border-collapse" id="table6">

                </table>
            </div>
        </div>
        <div class="hidden" id="tab4">
            <p class="mb-6 text-center text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Total Relation Matrix T</p>
            <div id="table7">

            </div>
        </div>

        <div class="hidden" id="tab5">
            <p class="mb-6 text-center text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Evaluate the sums of rows and columns in T matrix</p>
            <div id="table8">

            </div>
        </div>

        <div class="hidden" id="tab6">
            <p class="mb-6 text-center text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Defining the threshold value</p>
            <div id="table9">

            </div>
        </div>
    </section>

    <div id="modalConfirm" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow">
                <button onclick="modalConfirmClose()" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <form id="formDelete" action="{{ route('dashboard.bank.nullhypothesisdata.delete', ['code'  => \Route::current()->parameter('code')]) }}" method="post">
                        <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <input id="modalGroupId" type="hidden" name="groupId" value="">
                        <div class="flex flex-col w-full justify-center gap-2 mb-5">
                            <span class="text-lg font-normal text-gray-500">Are you sure you want to delete?</span>
                        </div>
                        <button id="formSubmit" type="submit" class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Delete
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const hypothesis = {!! json_encode($hypothesis) !!}

            /*
            * Show Tabs
            * */
            const  tabs = [
                {
                    'id' : 'tab1',
                    'name' : 'Null Hypothesis'
                },
                {
                    'id' : 'tab2',
                    'name' : 'Step 1 - All Variables'
                },
                {
                    'id' : 'tab3',
                    'name' : 'Step 2 - Normalize'
                },
                {
                    'id' : 'tab4',
                    'name' : 'Step 3 - Total Relation Matrix'
                },
                {
                    'id' : 'tab5',
                    'name' : 'Step 4 - Matrix'
                },
                {
                    'id' : 'tab6',
                    'name' : 'Step 5 - Treshold'
                }
            ]

            Object.keys(tabs).forEach((key, index) => {
                $('#selectTabs').append(`<option value="${tabs[key].id}">${tabs[key].name}</option>`)
            })

            $('#selectTabs').on('change', function () {
                let id = $('#selectTabs').val()
                Object.keys(tabs).forEach((key, index) => {

                    if(id != 'tab1') {
                        $('#addNew').addClass('hidden');
                    } else {
                        $('#addNew').removeClass('hidden');
                    }

                    if(id == tabs[key].id) {
                        $('#' + id).removeClass('hidden')
                    } else {
                        $('#' + tabs[key].id).addClass('hidden')
                    }
                })
            })

            $('#tbody').html('');
            Object.keys(hypothesis).forEach((key, index) => {
                $('#tbody').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="border py-4 px-6">${hypothesis[key].null_hypothesis}</td>
                        <td class="border py-4 px-6">` + blankForNull(`${hypothesis[key].obs}`) + `</td>
                        <td class="border py-4 px-6">${hypothesis[key].fStatic}</td>
                        <td class="border py-4 px-6">` + blankForNull(`${hypothesis[key].prob}`) + `</td>
                        `+ getActionBtn(`${hypothesis[key].group_id}`,`${hypothesis[key].id}`)+ `
                    </tr>
                `)
            })

            function blankForNull(value) {
                return value.toUpperCase() == "NULL" ? "" : value
            }

            function getActionBtn(groupId, dataId) {
                if(dataId % 2) {
                    return `<td rowspan="2" class="py-4 px-6 border">
                        <a href="/backoffice/{{Route::current()->parameter('code') }}/dashboard/bank/nullhypothesisdata/edit/`+groupId+`/`+dataId+`" class="py-0.5 px-2 bg-ds-yellow/20 text-ds-yellow rounded-lg cursor-pointer"><i class="fa-solid fa-pen"></i> Edit</a>
                        <button type="button" class="py-0.5 px-2 bg-ds-red/20 text-ds-red rounded-lg cursor-pointer" onclick="deleteData(`+groupId+`)">
                            <i class="fa-regular fa-trash-can"></i> Delete
                        </button>
                    </td>`
                } else {
                    return ''
                }
            }

            /**
             * Modal Confirm Delete
             */
            window.deleteData = deleteData
            window.modalConfirmClose = modalConfirmClose

            function deleteData(groupId) {
                $('#modalGroupId').val(groupId)
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
                modalConfirmClose()
                loadingButton(false, '#formSubmit', 'Delete')
            })

            /*
            * Get step 2 - Matrix variable
            * */
            $.get("nullhypothesisdata/variable", function(data){
                $('#table2').html(data)
            })

            /*
            * Get step 3 - Normalized variable
            * */
            $.get("nullhypothesisdata/normalizedVariable", function (data){
                $('#table3').html(data)
            })

            /*
            * Get Identity Matrix
            * */
            $.get("nullhypothesisdata/identityMatrix", function (data){
                $('#table4').html(data)
            })

            /*
            * Get matrix identity - matrix Y
            * */
            $.get("nullhypothesisdata/identityMatrixY", function (data){
                $('#table5').html(data)
            })

            /*
            * Get invers matrix
            * */
            $.get("nullhypothesisdata/minvers", function (data){
                $('#table6').html(data)
            })

            /*
            * Get total relation matrix
            * */
            $.get("nullhypothesisdata/relationmatrix", function (data){
                $('#table7').html(data)
            })

            /*
            * Get matrix
            * */
            $.get("nullhypothesisdata/matrix", function (data){
                $('#table8').html(data)
            })

            /*
            * Get Average
            * */
            $.get("nullhypothesisdata/average", function (data){
                $('#table9').html(data)
            })
        })
    </script>
@endpush
