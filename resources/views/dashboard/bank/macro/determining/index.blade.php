@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Determining Weight</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Step Macro, Determining Weight</span>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6" rowspan="2">Years</th>
                        <th scope="col" class="py-3 px-6" colspan="4">PRSSURE</th>
                        <th scope="col" class="py-3 px-6" rowspan="2">TOTAL</th>
                    </tr>
                    <tr>
                        <th scope="col" class="py-3 px-6">VAR IGDP</th>
                        <th scope="col" class="py-3 px-6">VAR IINF</th>
                        <th scope="col" class="py-3 px-6">VAR IER</th>
                        <th scope="col" class="py-3 px-6">VAR IJII</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($data as $item)
                        <tr>
                            <td class="py-4 px-6">{{$item['tahun']}}</td>
                            <td class="py-4 px-6">{{number_format($item['GDP'], 3)}}</td>
                            <td class="py-4 px-6">{{number_format($item['INF'], 3)}}</td>
                            <td class="py-4 px-6">{{number_format($item['ER'], 3)}}</td>
                            <td class="py-4 px-6">{{number_format($item['JII'], 3)}}</td>
                        </tr>
                    @endforeach
                    @foreach ($add_on as $KeyAdd => $itemx)
                        <tr>
                            <td class="py-4 px-6">{{$KeyAdd}}</td>
                            <td class="py-4 px-6">{{$itemx['gdp']}}</td>
                            <td class="py-4 px-6">{{$itemx['inf']}}</td>
                            <td class="py-4 px-6">{{$itemx['er']}}</td>
                            <td class="py-4 px-6">{{$itemx['jii']}}</td>
                            <td class="py-4 px-6">{{$itemx['total']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
