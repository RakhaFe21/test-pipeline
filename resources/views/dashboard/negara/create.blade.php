@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Country</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Country Data, Create</span>
            </div>
        </div>

        <div class="block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <form id="formCreate" method="POST" action="{{ route('dashboard.negara.store', ['code' => \Route::current()->parameter('code')]) }}">
              
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Nama</label>
                    <input id="npf" type="text" name="name" value="" 
                        class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                        required>
                    <span id="npfMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Code</label>
                    <input id="car" type="text" name="code" value="" 
                        class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                        required>
                    <span id="carMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="flex flex-row justify-start gap-4">
                    <button id="cancel" type="button"
                        class="bg-gray-50 hover:bg-gray-100 border border-ds-gray focus:ring-ds-gray focus:border-ds-gray font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>
                    <button id="formSubmit" type="submit"
                        class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm px-5 py-2.5">Save
                        Data</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

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
                    } else {
                        toastr.warning(data.message)
                    }
                } catch (error) {
                    this.reset()
                    toastr.error(error.message)
                }

                loadingButton(false, '#formSubmit', 'Save Data')
            })

            /**
             * Back
             */
            $('#cancel').on('click', function() {
                window.location = '{{ route('dashboard.negara.index', ['code' => \Route::current()->parameter('code')]) }}'
            })

        })
    </script>
@endpush