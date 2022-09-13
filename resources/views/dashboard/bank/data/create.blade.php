@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Data</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Banking, Data, Add New Data</span>
            </div>
        </div>

        <div class="block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <form id="formCreate" method="POST" action="{{ route('dashboard.dashboard.bank.data.store') }}">
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">YEAR & MONTH</label>
                    <div class="flex flex-row gap-4">
                        <select id="selectYears" name="year" class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[100px] p-2"></select>
                        <select id="selectMonths" name="month" class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[100px] p-2"></select>
                    </div>
                    <span id="tanggalMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">NPF</label>
                    <input id="npf" type="text" name="npf" value="" placeholder="Masukkan Data" class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5" required>
                    <span id="npfMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">CAR</label>
                    <input id="car" type="text" name="car" value="" placeholder="Masukkan Data" class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5" required>
                    <span id="carMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">IPR</label>
                    <input id="ipr" type="text" name="ipr" value="" placeholder="Masukkan Data" class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5" required>
                    <span id="iprMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">FDR</label>
                    <input id="fdr" type="text" name="fdr" value="" placeholder="Masukkan Data" class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5" required>
                    <span id="fdrMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="flex flex-row justify-start gap-4">
                    <button id="cancel" type="button" class="bg-gray-50 hover:bg-gray-100 border border-ds-gray focus:ring-ds-gray focus:border-ds-gray font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>
                    <button id="formSubmit" type="submit" class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm px-5 py-2.5">Save Data</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            years()
            months()

            /**
             * Set list Years
             */
            function years() {
                var data = []
                var now = moment().format('yyyy')
                var start = 2010
                const end = parseInt(now)
                while (start <= end) {
                    $('#selectYears').append(`<option value="${start}">${start}</option>`)
                    start = start + 1
                }
                return data
            }

            /**
             * Set list Month
             */
            function months() {
                var data = []
                var start = 1
                const end = 12
                while (start <= end) {
                    $('#selectMonths').append(`<option value="${start}">${start}</option>`)
                    start = start + 1
                }
                return data
            }

            /**
             * Form Create
             */
            $('#formCreate').submit(async function(e) {
                e.preventDefault()
                loadingButton(true, '#formSubmit', '')

                try {
                    const form = $(e.target);

                    const post = await axios({
                        method: 'post',
                        url: form.attr("action"),
                        headers: {},
                        data: form.serialize()
                    })

                    const data = post.data

                    if (data.code === 200) {
                        toastr.success(data.message)
                        this.reset()
                    } else if (data.code === 400) {
                        if (data.data.npf) {
                            $('#npf').addClass('border-red-500')
                            $('#npfMsg').removeClass('hidden').text(data.data.npf[0])
                        }
                        if (data.data.car) {
                            $('#car').addClass('border-red-500')
                            $('#carMsg').removeClass('hidden').text(data.data.car[0])
                        }
                        if (data.data.ipr) {
                            $('#ipr').addClass('border-red-500')
                            $('#iprMsg').removeClass('hidden').text(data.data.ipr[0])
                        }
                        if (data.data.fdr) {
                            $('#fdr').addClass('border-red-500')
                            $('#fdrMsg').removeClass('hidden').text(data.data.fdr[0])
                        }
                    } else {
                        toastr.warning(data.message)
                    }
                } catch (error) {
                    this.reset()
                    toastr.warning(error.message)
                }

                loadingButton(false, '#formSubmit', 'Save Data')
            })

            /**
             * Back
             */
            $('#cancel').on('click', function() {
                window.location = '{{ route('dashboard.dashboard.bank.data') }}'
            })

        })
    </script>
@endpush
