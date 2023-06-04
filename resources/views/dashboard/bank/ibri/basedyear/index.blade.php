@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Selecting Based Year</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Selecting Based Years</span>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">Variables</th>
                        <th scope="col" class="py-3 px-6">Base Year</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($weight as $key => $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">I{{strtoupper($item->variableMaster->nama_variable)}}</td>
                            <td class="py-4 px-6">{{$item->based_year}}</td>
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
