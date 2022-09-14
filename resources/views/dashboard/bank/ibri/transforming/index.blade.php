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
                        <th scope="col" class="py-3 px-6">Mean Base Year</th>
                        <th scope="col" class="py-3 px-6">CAR</th>
                        <th scope="col" class="py-3 px-6">Mean Base Year</th>
                        <th scope="col" class="py-3 px-6">IPR</th>
                        <th scope="col" class="py-3 px-6">Mean Base Year</th>
                        <th scope="col" class="py-3 px-6">FDR</th>
                        <th scope="col" class="py-3 px-6">Mean Base Year</th>
                    </tr>
                </thead>
                <tbody id="tbody">

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
