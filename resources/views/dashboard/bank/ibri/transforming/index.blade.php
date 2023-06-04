@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Transforming into Index</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Transforming into Index</span>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">YEARS</th>
                        <th scope="col" class="py-3 px-6">NPF</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
                        <th scope="col" class="py-3 px-6">CAR</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
                        <th scope="col" class="py-3 px-6">IPR</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
                        <th scope="col" class="py-3 px-6">FDR</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center justify-center gap-2">
                            <span>Mean</span>
                            <span>Base Year</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @php $i = 0 @endphp 
                    @foreach ($years as $key => $year)
                    <tr>  
                        <td class="py-4 px-6">{{$year[0]->tahun}}</td>  
                        <td class="py-4 px-6 {{ $min_npf == $stdevs[0][$i] ? 'text-ds-red font-bold' : ''}}">{{round($stdevs[0][$i], 3)}}</td>  
                        <td class="py-4 px-6 ">{{round($means[0][$i], 3)}}</td> 
                        <td class="py-4 px-6 {{ $min_car == $stdevs[1][$i] ? 'text-ds-red font-bold' : '' }}">{{round($stdevs[1][$i], 3)}}</td>  
                        <td class="py-4 px-6 ">{{round($means[1][$i], 3)}}</td>
                        <td class="py-4 px-6 {{ $min_ipr == $stdevs[2][$i] ? 'text-ds-red font-bold' : '' }}">{{round($stdevs[2][$i], 3)}}</td>  
                        <td class="py-4 px-6 ">{{round($means[2][$i], 3)}}</td>
                        <td class="py-4 px-6 {{ $min_fdr == $stdevs[3][$i] ? 'text-ds-red font-bold' : '' }}">{{round($stdevs[3][$i], 3)}}</td>  
                        <td class="py-4 px-6 ">{{round($means[3][$i], 3)}}</td>    
                    </tr>
                    @php $i++ @endphp
                    @endforeach
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
