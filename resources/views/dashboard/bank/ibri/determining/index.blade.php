@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Determining Weight</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Determining Weight</span>
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
                        <th scope="col" class="py-3 px-6">VAR INPF</th>
                        <th scope="col" class="py-3 px-6">VAR ICAR</th>
                        <th scope="col" class="py-3 px-6">VAR IIPR</th>
                        <th scope="col" class="py-3 px-6">VAR IFDR</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($data as $item)
                        <tr>
                            <td class="py-4 px-6">{{$item['tahun']}}</td>
                            <td class="py-4 px-6">{{$item['NPF']}}</td>
                            <td class="py-4 px-6">{{$item['CAR']}}</td>
                            <td class="py-4 px-6">{{$item['IPR']}}</td>
                            <td class="py-4 px-6">{{$item['FDR']}}</td>
                        </tr>
                    @endforeach
                    @foreach ($add_on as $KeyAdd => $itemx)
                        <tr>
                            <td class="py-4 px-6">{{$KeyAdd}}</td>
                            <td class="py-4 px-6">{{$itemx['npf']}}</td>
                            <td class="py-4 px-6">{{$itemx['car']}}</td>
                            <td class="py-4 px-6">{{$itemx['ipr']}}</td>
                            <td class="py-4 px-6">{{$itemx['fdr']}}</td>
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
