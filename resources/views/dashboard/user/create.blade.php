@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">User Data</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>User Data, Create</span>
            </div>
        </div>

        <div class="block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <form id="formCreate" method="POST" action="{{ route('dashboard.user.store', ['code' => \Route::current()->parameter('code')]) }}" enctype="multipart/form-data">
              
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Nama</label>
                    <input id="file" type="text" name="name" value="" placeholder="Masukkan Nama"
                        class=" border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                        required>
                    <span id="fileMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Username</label>
                    <input id="car" type="text" name="username" value="" placeholder="Masukkan Username"
                    class=" border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                    required>
                    <span id="carMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Email</label>
                    <input id="car" type="text" name="email" value="" placeholder="Masukkan Email"
                    class=" border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                        required>
                    <span id="carMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Password</label>
                    <input id="car" type="password" name="password" value="" placeholder="Masukkan Password"
                    class=" border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                    required>
                    <span id="carMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Role</label>
                    <select class="bg-black-50 border-gray-300 text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5" name="role" id="role">
                        <option value="0">User</option>
                        <option value="1">Admin</option>
                        <option value="2">Super Admin</option>
                    </select>
                    <span id="carMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Address</label>
                    <input id="car" type="text" name="address" value="" placeholder="Masukkan Alamat"
                    class=" border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                    required>
                    <span id="carMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-normal">Profile</label>
                    <input id="file" type="file" name="image" placeholder="Masukkan File">
                    <span id="fileMsg" class="hidden mt-2 text-xs text-red-500"></span>
                </div>
                <div class="flex flex-row justify-start gap-4">
                    <button id="cancel" type="button"
                        class=" hover:bg-gray-100 border border-ds-gray focus:ring-ds-gray focus:border-ds-gray font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>
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
                    console.log(form);

                    const post = await axios({
                        method: 'post',
                        url: form.attr("action"),
                        headers: {},
                        data: new FormData(form[0])
                    })

                    const data = post.data

                    if (data.code === 200) {
                        toastr.success(data.message)
                        this.reset()
                    } else {
                        toastr.warning(data.message)
                    }
                } catch (error) {
                    toastr.error(error.message)
                }

                loadingButton(false, '#formSubmit', 'Save Data')
            })

            /**
             * Back
             */
            $('#cancel').on('click', function() {
                window.location = '{{ route('dashboard.user.index', ['code' => \Route::current()->parameter('code')]) }}'
            })

        })
    </script>
@endpush