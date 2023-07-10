@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px]  h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Visualization</h1>
        <p class="mb-5">Memberikan informasi penting dari kondisi perbankan islam. Disajikan dengan menampilkan beberapa rekomendasi & kondisi yang perlu dicapai bagi indikator utama makroekonomi dan internal perbankan untuk mencapai dan memelihara tingkat ketahanan perbankan. Perbankan dapat mencapai dan memelihara tingkat ketahanan dengan menempatkan indikator utama makroekonomi dan variable terpilih internal perbankan dalam kondisi yang optimal dalam rentang tertentu.</p>

        <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th scope="col" class="p-4">No</th>
                        <th scope="col" class="p-4">Indicator</th>
                        <th scope="col" class="p-4">Caegory</th>
                        <th scope="col" class="p-4">Model</th>
                        <th scope="col" class="p-4">Trend</th>
                        <th scope="col" class="p-4">Treshold</th>
                        <th scope="col" class="p-4">Time Horizon</th>
                        <th scope="col" class="p-4">Accuracy <br>(QPS)</th>
                        <th scope="col" class="p-4">Predictive <br>Power (GSB)</th>
                        <th scope="col" class="p-4">Loss Function</th>
                        <th scope="col" class="p-4">Resilience <br> Level</th>
                        <th scope="col" class="p-4">Optimal</th>
                        <th scope="col" class="p-4">Tolerance</th>
                        <th scope="col" class="p-4">Stagnant</th>
                        <th scope="col" class="p-4">Vulnerable</th>
                        <th scope="col" class="p-4">C(Probability of Crisis <br> Without Signal)</th>
                        <th scope="col" class="p-4">C(Probability of Crisis <br> Without Signal)</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="17" class="py-3 px-6">Lamdha =14400, Level of Multiplier 14000</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr><th scope="col" colspan="17" class="py-3 px-6">Components of Composite Index</th></tr>
                        <tr class="bg-ld-green/10"> 
                            <td class="border border-slate-300 py-4 ">1 A</td>
                            <td rowspan="2" class="border border-slate-300 py-4">Composite Index</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">Individual Index</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">µ = 0,5</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">One-sided HP Filter</td>
                            <td class="border border-slate-300 py-4">Upper Treshold</td> 
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td rowspan="2" class="border border-slate-300 py-4">optimal</td>
                            <td rowspan="2" class="border border-slate-300 py-4">tolerance</td>
                            <td rowspan="2" class="border border-slate-300 py-4">stagnant</td>
                            <td rowspan="2" class="border border-slate-300 py-4">vulnerable</td>
                            <td class="border border-slate-300 py-4">20%</td>
                            <td class="border border-slate-300 py-4">10%</td>
                        </tr>
                        <tr class="bg-ld-green/10">
                            <td class="border border-slate-300 py-4 ">1 A</td>
                            <td class="border border-slate-300 py-4">Lower Treshold</td>
                            <td class="border border-slate-300 py-4">3.14</td>
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td class="border border-slate-300 py-4">10 %</td>

                        </tr>
                        <tr><th scope="col" colspan="17" class="py-3 px-6">Elements of Composite Index</th></tr>
                        <tr class="bg-ld-green/10"> 
                            <td class="border border-slate-300 py-4 ">2 A</td>
                            <td rowspan="2" class="border border-slate-300 py-4">NPF</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">Dimension Index</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">µ = 0,5</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">One-sided HP Filter</td>
                            <td class="border border-slate-300 py-4">Upper Treshold</td> 
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td rowspan="2" class="border border-slate-300 py-4">optimal</td>
                            <td rowspan="2" class="border border-slate-300 py-4">tolerance</td>
                            <td rowspan="2" class="border border-slate-300 py-4">stagnant</td>
                            <td rowspan="2" class="border border-slate-300 py-4">vulnerable</td>
                            <td class="border border-slate-300 py-4">20%</td>
                            <td class="border border-slate-300 py-4">10%</td>
                        </tr>
                        <tr class="bg-ld-green/10">
                            <td class="border border-slate-300 py-4 ">2 A</td>
                            <td class="border border-slate-300 py-4">Lower Treshold</td>
                            <td class="border border-slate-300 py-4">3.14</td>
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td class="border border-slate-300 py-4">10 %</td>

                        </tr>
                        <tr class="bg-ld-green/10"> 
                            <td class="border border-slate-300 py-4 ">3 A</td>
                            <td rowspan="2" class="border border-slate-300 py-4">CAR</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">Dimension Index</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">µ = 0,5</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">One-sided HP Filter</td>
                            <td class="border border-slate-300 py-4">Upper Treshold</td> 
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td rowspan="2" class="border border-slate-300 py-4">optimal</td>
                            <td rowspan="2" class="border border-slate-300 py-4">tolerance</td>
                            <td rowspan="2" class="border border-slate-300 py-4">stagnant</td>
                            <td rowspan="2" class="border border-slate-300 py-4">vulnerable</td>
                            <td class="border border-slate-300 py-4">20%</td>
                            <td class="border border-slate-300 py-4">10%</td>
                        </tr>
                        <tr class="bg-ld-green/10">
                            <td class="border border-slate-300 py-4 ">3 A</td>
                            <td class="border border-slate-300 py-4">Lower Treshold</td>
                            <td class="border border-slate-300 py-4">3.14</td>
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td class="border border-slate-300 py-4">10 %</td>

                        </tr>
                        <tr class="bg-ld-green/10"> 
                            <td class="border border-slate-300 py-4 ">4 A</td>
                            <td rowspan="2" class="border border-slate-300 py-4">IPR</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">Dimension Index</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">µ = 0,5</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">One-sided HP Filter</td>
                            <td class="border border-slate-300 py-4">Upper Treshold</td> 
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td rowspan="2" class="border border-slate-300 py-4">optimal</td>
                            <td rowspan="2" class="border border-slate-300 py-4">tolerance</td>
                            <td rowspan="2" class="border border-slate-300 py-4">stagnant</td>
                            <td rowspan="2" class="border border-slate-300 py-4">vulnerable</td>
                            <td class="border border-slate-300 py-4">20%</td>
                            <td class="border border-slate-300 py-4">10%</td>
                        </tr>
                        <tr class="bg-ld-green/10">
                            <td class="border border-slate-300 py-4 ">4 A</td>
                            <td class="border border-slate-300 py-4">Lower Treshold</td>
                            <td class="border border-slate-300 py-4">3.14</td>
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td class="border border-slate-300 py-4">10 %</td>

                        </tr>
                        <tr class="bg-ld-green/10"> 
                            <td class="border border-slate-300 py-4 ">5 A</td>
                            <td rowspan="2" class="border border-slate-300 py-4">FDR</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">Dimension Index</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">µ = 0,5</td>
                            <td rowspan="2" class="border border-slate-300 py-4 px-6">One-sided HP Filter</td>
                            <td class="border border-slate-300 py-4">Upper Treshold</td> 
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td rowspan="2" class="border border-slate-300 py-4">optimal</td>
                            <td rowspan="2" class="border border-slate-300 py-4">tolerance</td>
                            <td rowspan="2" class="border border-slate-300 py-4">stagnant</td>
                            <td rowspan="2" class="border border-slate-300 py-4">vulnerable</td>
                            <td class="border border-slate-300 py-4">20%</td>
                            <td class="border border-slate-300 py-4">10%</td>
                        </tr>
                        <tr class="bg-ld-green/10">
                            <td class="border border-slate-300 py-4 ">5 A</td>
                            <td class="border border-slate-300 py-4">Lower Treshold</td>
                            <td class="border border-slate-300 py-4">3.14</td>
                            <td class="border border-slate-300 py-4">3.14</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">2.00</td> 
                            <td class="border border-slate-300 py-4">2.00</td>
                            <td class="border border-slate-300 py-4">20 %</td>
                            <td class="border border-slate-300 py-4">10 %</td>

                        </tr>

                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        })
    </script>
@endpush
