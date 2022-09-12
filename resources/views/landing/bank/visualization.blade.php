@extends('template.landing')

@section('content')
    <section class="flex flex-col gap-2 container mx-auto px-4 py-10 lg:px-[100px]  h-full min-h-screen">
        <h1 class="text-[30px] font-medium text-ld-green">Visualization</h1>
        <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nisl amet dignissim purus vestibulum ac suscipit imperdiet quisque vulputate. Egestas neque adipiscing lorem non praesent faucibus. Blandit ornare dui vestibulum mauris nec.</p>

        <div class="overflow-auto w-full flex flex-row text-center text-ld-green">
            <table class="w-full">
                <thead>
                    <tr class="bg-ld-green/40">
                        <th class="p-4">NO</th>
                        <th class="p-4">Indicator</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Model</th>
                        <th class="p-4">Trend</th>
                        <th class="p-4">Threshold</th>
                        <th class="p-4">Time Horizon</th>
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
