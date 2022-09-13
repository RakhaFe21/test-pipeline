@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px]  h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Theoritical Framework</h1>
        <p class="mb-5">Berikut ini ada 15 step untuk membangun Indeks Ketahanan Perbankan Syariah. Data yang kami sajikan berupa Tabel (Constructing The Islamic Banking Resilience Index ) dan gambar (Constructing The Islamic Banking Resilience Index )</p>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap text-sm font-medium text-center" id="tab" data-tabs-toggle="#tabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="table-tab" data-tabs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">Table</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="gambar-tab" data-tabs-target="#gambar" type="button" role="tab" aria-controls="gambar" aria-selected="false">Gambar</button>
                </li>
            </ul>
        </div>
        <div id="tabContent">
            <div class="hidden" id="table" role="tabpanel" aria-labelledby="table-tab">
                <div class="flex flex-col gap-2 overflow-auto">
                    <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-ld-green/40">
                                    <th class="p-4">NO</th>
                                    <th class="p-4">Constructing The Macroeconomic Vulnerability Index</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="hidden flex flex-row items-center justify-center pt-10" id="gambar" role="tabpanel" aria-labelledby="gambar-tab">
                <img src="{{ asset('img/theoritical.png') }}" alt="" class="rounded-lg">
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
                    <tr>
                        <td class="colspan-13 p-2"></td>
                    </tr>
                    <tr class="bg-ld-green/10">
                        <td class="p-2">${data[key].no}</td>
                        <td class="p-2">${data[key].data}</td>
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
                activeClasses: 'text-ld-green hover:text-ld-green border-ld-green',
                inactiveClasses: 'text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300',
                onShow: () => {
                    //console.log('tab is shown')
                }
            }

            const tabs = new Tabs(tabElements, options)
            tabs.show('table')
            tabs.getTab('gambar')
            //console.log(tabs.getActiveTab().id);
        })
    </script>
@endpush
