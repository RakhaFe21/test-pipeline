@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Variable</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Variable</span>
            </div>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">NO</th>
                        <th scope="col" class="py-3 px-6 flex flex-col items-center gap-2">
                            <span>Islamic Banking Variables</span>
                            <span class="font-normal">Otoritas Jasa Keuangan/OJK</span>
                        </th>
                        <th scope="col" class="py-3 px-6">Form</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">A</th>
                        <td class="py-4 px-6">Non-performing financing (NPF)</td>
                        <td class="py-4 px-6">%</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">B</th>
                        <td class="py-4 px-6">Capital Adequacy Ratio (CAR)</td>
                        <td class="py-4 px-6">%</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">C</th>
                        <td class="py-4 px-6">Investment Proportion and Risk (IPR)</td>
                        <td class="py-4 px-6">%</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">D</th>
                        <td class="py-4 px-6">Financings to Deposits Ratio (FDR)</td>
                        <td class="py-4 px-6">%</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>
@endsection
