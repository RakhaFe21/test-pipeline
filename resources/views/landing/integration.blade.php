@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px]  h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Visualization</h1>
        <p class="mb-5">{{ __('integration.desc') }}</p>

        <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th class="p-4">Indicator</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Model</th>
                        <th class="p-4">Trend</th>
                        <th class="p-4">Threshold</th>
                        <th class="p-4">Time Horizon</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr>
                        <td class="colspan-6 p-2"></td>
                    </tr>
                    <tr class="bg-ld-green/10">
                        <td class="p-2">OPERATIONAL RESILIENCE</td>
                        <td class="p-2">Dimenssion Index</td>
                        <td class="p-2">µ = 0,5</td>
                        <td class="p-2">One-sided HP Filter</td>
                        <td class="p-2">One-sided HP Filter</td>
                        <td class="p-2">12</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-row justify-center items-center p-5 bg-ld-yellow mt-[100px]">
            <span class="text-ld-red text-[24px] font-medium">{{ __('integration.attention') }} 93%-100% !!</span>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        })
    </script>
@endpush
