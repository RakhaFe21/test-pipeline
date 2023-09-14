@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Theoritical Framework</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Macro, Data, Theoritical Framework</span>
            </div>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap text-sm font-medium text-center" id="tab" data-tabs-toggle="#tabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="table-tab" data-tabs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">Table</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="gambar-tab" data-tabs-target="#gambar" type="button" role="tab" aria-controls="gambar" aria-selected="false">Image</button>
                </li>
            </ul>
        </div>
        <div id="tabContent">
            <div class="hidden" id="table" role="tabpanel" aria-labelledby="table-tab">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-center">
                        <thead class="text-xs uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">NO</th>
                                <th scope="col" class="py-3 px-6">Constructing The Islamic Bankin Resilience Index</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden flex flex-row items-center justify-center pt-10" id="gambar" role="tabpanel" aria-labelledby="gambar-tab">
                <img src="{{ asset('img/theoritical.png') }}" alt="">
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const data = [{
                    "no": "1",
                    "data": "Developing a Theoretical Framework"
                },
                {
                    "no": "2",
                    "data": "Tranforming into Index"
                },
                {
                    "no": "3",
                    "data": "Selecting BAse Year"
                },
                {
                    "no": "4",
                    "data": "Determining Weight"
                },
                {
                    "no": "5",
                    "data": "Index Agregation"
                },
                {
                    "no": "6",
                    "data": "Factor Analysis"
                },
                {
                    "no": "7",
                    "data": "Setting Threshold"
                },
                {
                    "no": "8",
                    "data": "Signaling Threshold"
                },
                {
                    "no": "9",
                    "data": "In Sample Model 5"
                },
                {
                    "no": "10",
                    "data": "Out Sample Model"
                },
                {
                    "no": "11",
                    "data": "Out Sample Performance"
                },
                {
                    "no": "12",
                    "data": "Determining the optimal level in Index Value"
                },
                {
                    "no": "13",
                    "data": "Calculating the optimal level in Real Value"
                },
                {
                    "no": "14",
                    "data": "Setting the Heat Map"
                },
                {
                    "no": "15",
                    "data": "Visualization"
                },
            ]

            Object.keys(data).forEach((key, index) => {
                $('#tbody').append(`
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6">${data[key].no}</td>
                        <td class="py-4 px-6">${data[key].data}</td>
                    </tr>
                `)
            })

            const tabElements = [{
                    id: 'table',
                    triggerEl: document.querySelector('#table-tab'),
                    targetEl: document.querySelector('#table')
                },
                {
                    id: 'gambar',
                    triggerEl: document.querySelector('#gambar-tab'),
                    targetEl: document.querySelector('#gambar')
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
            tabs.getTab('gambar')
        })
    </script>
@endpush
