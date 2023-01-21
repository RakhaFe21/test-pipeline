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
                <option value="tab1">Hypothesis</option>
                <option value="tab2">Step 1 - All Variables</option>
                <option value="tab3">Step 2 - Normalize</option>
                <option value="tab4">Step 3 - Total Relation Matrix</option>
                <option value="tab5">Step 4 - Matrix</option>
                <option value="tab6">Step 5 - Treshold</option>
            </select>
            <a id="addNew" href="{{ route('dashboard.bank.hypothesysdata.create') }}"
                class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm px-5 py-2.5"><i
                    class="fa-solid fa-plus"></i> Add New</a>
        </div>

        <div class="" id="tab1">
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
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const hypothesis = {!! json_encode($hypothesis) !!};
            console.log(hypothesis);
            $('#tbody').html('');
            Object.keys(hypothesis).forEach((key, index) => {
                $('#tbody').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">${hypothesis[key].null_hypothesis}</td>
                        <td class="py-4 px-6">` + blankForNull(`${hypothesis[key].obs}`) + `</td>
                        <td class="py-4 px-6">${hypothesis[key].fStatic}</td>
                        <td class="py-4 px-6">` + blankForNull(`${hypothesis[key].prob}`) + `</td>
                        <td class="py-4 px-6 flex flex-row gap-2 items-center justify-center">
                                <a href="/dashboard/bank/nullhypothesisdata/edit/${hypothesis[key].id}" class="py-0.5 px-2 bg-ds-yellow/20 text-ds-yellow rounded-lg cursor-pointer"><i class="fa-solid fa-pen"></i> Edit</a>
                                <button type="button" class="py-0.5 px-2 bg-ds-red/20 text-ds-red rounded-lg cursor-pointer" onclick="deleteData(${hypothesis[key].id})">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                        </td>
                    </tr>
                `);
            });

            function blankForNull(value) {
                return value.toUpperCase() == "NULL" ? "" : value;
            }
        });
    </script>
@endpush
