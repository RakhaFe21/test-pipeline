@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Factor Analysis-AHP</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Factor Analysis-AHP</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <select id="selectTabs"
                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block p-2.5 pr-10"></select>
        </div>

        <div id="tab1" class="">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">VARIABLES</th>
                            <th scope="col" class="py-3 px-6">INPF</th>
                            <th scope="col" class="py-3 px-6">ICAR</th>
                            <th scope="col" class="py-3 px-6">IIPR</th>
                            <th scope="col" class="py-3 px-6">IFDR</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($weights as $key => $weight)
                            <tr>
                                <td class="py-4 px-6">I{{strtoupper($weight->nama_variable)}}</td>
                                <td class="py-4 px-6 {{ $npf[$key] == 1 ? 'text-ds-yellow font-medium' : ''}}">{{round($npf[$key], 2)}}</td>
                                <td class="py-4 px-6 {{ $car[$key] == 1 ? 'text-ds-yellow font-medium' : ''}}">{{round($car[$key], 2)}}</td>
                                <td class="py-4 px-6 {{ $ipr[$key] == 1 ? 'text-ds-yellow font-medium' : ''}}">{{round($ipr[$key], 2)}}</td>
                                <td class="py-4 px-6 {{ $fdr[$key] == 1 ? 'text-ds-yellow font-medium' : ''}}">{{round($fdr[$key], 2)}}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6"><strong>TOTAL</strong></td>
                            <td class="py-4 px-6 ">{{round($total[0], 2)}}</td>
                            <td class="py-4 px-6 ">{{round($total[1], 2)}}</td>
                            <td class="py-4 px-6 ">{{round($total[2], 2)}}</td>
                            <td class="py-4 px-6 ">{{round($total[3], 2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">Rank</th>
                            <th scope="col" class="py-3 px-6">Weight</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRank">
                        @foreach ($weightRank as $item)
                            <tr>
                                <td class="py-4 px-6">I{{strtoupper($item->nama_variable)}}</td>
                                <td class="py-4 px-6">{{round($item->weight, 3)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab2" class="hidden">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">VARIABLES</th>
                            <th scope="col" class="py-3 px-6">INPF</th>
                            <th scope="col" class="py-3 px-6">ICAR</th>
                            <th scope="col" class="py-3 px-6">IIPR</th>
                            <th scope="col" class="py-3 px-6">IFDR</th>
                            <th scope="col" class="py-3 px-6">CRITERIA</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCriteria">
                        @foreach ($weights as $key => $weight)
                            <tr>
                                <td class="py-4 px-6">I{{strtoupper($weight->nama_variable)}}</td>
                                <td class="py-4 px-6 text-ds-yellow font-medium ">{{round($normalized_npf[$key], 2)}}</td>
                                <td class="py-4 px-6 text-ds-yellow font-medium ">{{round($normalized_car[$key], 2)}}</td>
                                <td class="py-4 px-6 text-ds-yellow font-medium ">{{round($normalized_ipr[$key], 2)}}</td>
                                <td class="py-4 px-6 text-ds-yellow font-medium ">{{round($normalized_fdr[$key], 2)}}</td>
                                <td class="py-4 px-6 ">{{round($criteria_weights[$key], 2)}}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6"><strong>TOTAL</strong></td>
                            <td class="py-4 px-6 ">{{round($total_normalized[0], 2)}}</td>
                            <td class="py-4 px-6 ">{{round($total_normalized[1], 2)}}</td>
                            <td class="py-4 px-6 ">{{round($total_normalized[2], 2)}}</td>
                            <td class="py-4 px-6 ">{{round($total_normalized[3], 2)}}</td>
                            <td class="py-4 px-6 ">{{round($total_normalized[4], 2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab3" class="hidden">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-center">
                    <thead id="theadCriteriaWeight" class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">CRITERIA WEIGHT</th>
                            @foreach ($criteria_weights as $criteria)
                                <th scope="col" class="py-3 px-6">{{round($criteria, 2);}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="col" class="py-3 px-6">VARIABLES</th>
                            <th scope="col" class="py-3 px-6">INPF</th>
                            <th scope="col" class="py-3 px-6">ICAR</th>
                            <th scope="col" class="py-3 px-6">IIPR</th>
                            <th scope="col" class="py-3 px-6">IFDR</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCriteriaWeight">
                        @foreach ($weights as $key => $weight)
                            <tr>
                                <td class="py-4 px-6">I{{strtoupper($weight->nama_variable)}}</td>
                                <td class="py-4 px-6 ">{{round($chy_npf[$key], 2)}}</td>
                                <td class="py-4 px-6 ">{{round($chy_car[$key], 2)}}</td>
                                <td class="py-4 px-6 ">{{round($chy_ipr[$key], 2)}}</td>
                                <td class="py-4 px-6 ">{{round($chy_fdr[$key], 2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                <table class="w-full text-sm text-left text-center">
                    <thead class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="py-3 px-6">Weighted Sum Value</th>
                            <th scope="col" class="py-3 px-6">Ceriteria Weighted</th>
                            <th scope="col" class="py-3 px-6">Ratio</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyWeightedSum">
                        @foreach ($weight_sum_values as $keyW => $weight_sum_value)
                        <tr>
                            <td class="py-4 px-6">{{round($weight_sum_values[$keyW], 2)}}</td>
                            <td class="py-4 px-6">{{round($criteria_weights[$keyW], 2)}}</td>
                            <td class="py-4 px-6">{{round($ratio[$keyW], 2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                <table class="w-full text-sm text-left text-center">
                    <thead id="theadCriteriaWeight" class="text-xs uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="" colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody id="tbodyLamda">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">Lamnda Max</td>
                            <td class="py-4 px-6">{{round($lamda_max, 2)}}</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">CI</td>
                            <td class="py-4 px-6">{{round($ci, 2)}}</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">Random Index</td>
                            <td class="py-4 px-6">{{round($ri, 2)}}</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">Consistency Ration</td>
                            <td class="py-4 px-6">{{round($consistency_ratio, 2)}}</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">%</td>
                            <td class="py-4 px-6">{{($percent)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="tab4" class="hidden">
            <img src="{{ asset('img/fundamental-scale.png') }}" alt="">
        </div>
        <div id="tab5" class="hidden">
            <img src="{{ asset('img/random-index.png') }}" alt="">
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

           
            const tabs = [{
                    'id': 'tab1',
                    'name': 'Step 1-Matrix Analysis of Islamic Bangking Variables'
                },
                {
                    'id': 'tab2',
                    'name': 'Step 2-Normalized'
                },
                {
                    'id': 'tab3',
                    'name': 'Step 3-CHY Consistency'
                },
                {
                    'id': 'tab4',
                    'name': 'Step 4-Fundamental Scale'
                },
                {
                    'id': 'tab5',
                    'name': 'Step 5-Random Index RI'
                }
            ]

            Object.keys(tabs).forEach((key, index) => {
                $('#selectTabs').append(`<option value="${tabs[key].id}">${tabs[key].name}</option>`)
            })

            $('#selectTabs').on('change', function() {
                let id = $(this).val()
                Object.keys(tabs).forEach((key, index) => {
                    if (id == tabs[key].id) {
                        $('#' + id).removeClass('hidden')
                    } else {
                        $('#' + tabs[key].id).addClass('hidden')
                    }
                })
            })

        })
    </script>
@endpush
