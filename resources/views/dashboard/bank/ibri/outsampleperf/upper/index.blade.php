@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Upper Threshold</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Out Sample Performance, Upper Threshold</span>
            </div>
        </div>



        <div class="box-border h-32 w-32 p-4 border-4 bg-gray-100 rounded-lg mb-4">
            <div class="inline-block flex">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2 ml-4" for="variable">
                        Variable Used
                    </label>
                    <select
                        class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray flex w-full w-[100px] p-3.5 ml-4" id="selectVariable">
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4" id="tableDiv1">
            <table class="w-full text-sm text-left text-center" id="OutSamplePerformanceTable">
                <thead class="text-xs uppercase bg-gray-200" id="headerOSPTable">
                    <tr>
                        <th scope="col" class="py-3 px-6">MONTHS</th>
                        <th scope="col" class="py-3 px-6">LF</th>
                        <th scope="col" class="py-3 px-6">QPS</th>
                        <th scope="col" class="py-3 px-6">GSB</th>
                    </tr>
                </thead>
                <tbody id="bodyOSPTable">

                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            
            const tahun = {!! json_encode($tahun) !!}
            const variable = {!! json_encode($variable) !!}
            

            Object.keys(variable).forEach((key, index) => {
                $('#selectVariable').append(`<option value="${variable[key].id}">${variable[key].nama_variable.toUpperCase()}</option>`)
            })
            
        })

        function renderTable(code) {
            let months = [
                '3 Month','6 Month','12 Month', '24 Month',
            ]
            $('#bodyOSPTable').html('')
            months.forEach(month => {
                $('#bodyOSPTable').append(`
                    <tr class="bg-white border-b">
                        <td class="py-4 px-6">${month}</td>
                        <td class="py-4 px-6">${code}</td>
                        <td class="py-4 px-6">${code}</td>
                        <td class="py-4 px-6">${code}</td>
                    </tr>
                `)
            });
            
        }
        renderTable($('#selectVariable').val())

        $('#selectVariable').on('change', function () {
            let selectVariable = $(this).val()
            renderTable(selectVariable)
        })
                    
                
    </script>
@endpush