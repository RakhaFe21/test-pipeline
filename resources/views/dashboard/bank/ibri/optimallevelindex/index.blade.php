@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Optimal Level In Index</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Optimal Level In Index</span>
            </div>
        </div>

        <div class="box-border h-32 w-32 p-4 border-4 bg-gray-100 rounded-lg mb-4">
            <div class="inline-block flex">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="variable">
                        Variable
                    </label>
                    <select
                        class="bg-gray-50 flex w-full border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray p-3.5 mr-4" id="selectVariable">
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2 ml-4" for="tahun">
                        Tahun
                    </label>
                    <select
                        class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray flex w-full w-[100px] p-3.5 ml-4" id="selectYear">
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap text-sm font-medium text-center" id="tab" data-tabs-toggle="#tabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="table-tab" data-tabs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">Table</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="chart-tab" data-tabs-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="false">Grafis</button>
                </li>
            </ul>
        </div>
        <div id="tabContent">
            <div class="hidden" id="table" role="tabpanel" aria-labelledby="table-tab">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-center">
                        <thead class="text-xs uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">Months</th>
                                <th scope="col" class="py-3 px-6" id="variableName-column">Variable</th>
                                <th scope="col" class="py-3 px-6">Upper TH <br>12 Month</th>
                                <th scope="col" class="py-3 px-6">Average Total</th>
                                <th scope="col" class="py-3 px-6">Lower TH <br>12 Month</th>
                                <th scope="col" class="py-3 px-6">Description</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden flex flex-row items-center justify-center pt-10" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                <h1>INI CHART</h1>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const tahun = {!! json_encode($tahun) !!}
            const variable = {!! json_encode($variable) !!}

            Object.keys(tahun).forEach((key, index) => {
                $('#tbody').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">${tahun[key].tahun}</td>
                        <td class="py-4 px-6">${tahun[key].id}</td>
                        <td class="py-4 px-6">${tahun[key].id}</td>
                        <td class="py-4 px-6">${tahun[key].id}</td>
                        <td class="py-4 px-6">${tahun[key].id}</td>
                        <td class="py-4 px-6">${tahun[key].id}</td>
                    </tr>
                `)
            })

            Object.keys(variable).forEach((key, index) => {
                $('#selectVariable').append(`<option value="${variable[key].id}">I${variable[key].nama_variable.toUpperCase()}</option>`)
            })

            Object.keys(tahun).forEach((key, index) => {
                $('#selectYear').append(`<option value="${tahun[key].tahun}">${tahun[key].tahun}</option>`)
            })

            const tabElements = [{
                    id: 'table',
                    triggerEl: document.querySelector('#table-tab'),
                    targetEl: document.querySelector('#table')
                },
                {
                    id: 'chart',
                    triggerEl: document.querySelector('#chart-tab'),
                    targetEl: document.querySelector('#chart')
                }
            ];

            const options = {
                defaultTabId: 'settings',
                activeClasses: 'text-ds-blue hover:text-ds-blue border-ds-blue',
                inactiveClasses: 'text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300',
                onShow: () => {}
            }

            const tabs = new Tabs(tabElements, options)
            tabs.show('table')
            tabs.getTab('chart')
        })
    </script>
@endpush
