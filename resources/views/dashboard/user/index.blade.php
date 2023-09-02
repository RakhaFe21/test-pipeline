@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">User Data</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>User Data</span>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center content-center w-full mb-6">
            <a id="addNew" href="{{ route('dashboard.user.create' , ['code'  => \Route::current()->parameter('code')]) }}" class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm px-5 py-2.5"><i class="fa-solid fa-plus"></i> Add New</a>
        </div>

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-center mb-3">
                <thead class="text-xs uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">No</th>
                        <th scope="col" class="py-3 px-6">Name</th>
                        <th scope="col" class="py-3 px-6">Email</th>
                        <th scope="col" class="py-3 px-6">Role</th>
                        <th scope="col" class="py-3 px-6">Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($users as $user)
                        <tr>
                            <td class="py-4 px-6">{{ $users->firstItem() + $loop->index }}</td>
                            <td class="py-4 px-6">{{ $user->name }}</td>
                            <td class="py-4 px-6">{{ $user->email }}</td>
                            <td class="py-4 px-6">{{ $user->role_label }}</td>
                            <td class="py-4 px-6 flex flex-row gap-2 items-center justify-center">
                                <a href="{{ route('dashboard.user.edit', ['code'  => \Route::current()->parameter('code'), 'id' => $user->id]) }}" class="py-0.5 px-2 bg-ds-yellow/20 text-ds-yellow rounded-lg cursor-pointer"><i class="fa-solid fa-pen"></i> Edit</a>
                                <button type="button" class="py-0.5 px-2 bg-ds-red/20 text-ds-red rounded-lg cursor-pointer" onclick="deleteData({{ $user->id }})">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
        <div>

        </div>
    </section>

    <div id="modalConfirm" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow">
                <button onclick="modalConfirmClose()" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <form id="formDelete" action="{{ route('dashboard.user.delete' , ['code'  => \Route::current()->parameter('code'), 'id' => $user->id ]) }}" method="post">
                        <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <input id="id" type="hidden" name="id" value="">
                        <div class="flex flex-col w-full justify-center gap-2 mb-5">
                            <span class="text-lg font-normal text-gray-500">Are you sure you want to delete?</span>
                            <span id="modalText"></span>
                        </div>
                        <button id="formSubmit" type="submit" class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Delete
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
           

            /**
             * Modal Confirm Delete
             */
            window.deleteData = deleteData
            window.modalConfirmClose = modalConfirmClose

            function deleteData(id) {
                $('#id').val(id)
                modal(document.getElementById('modalConfirm'), null, 1)
            }

            function modalConfirmClose() {
                modal(document.getElementById('modalConfirm'), null, 0)
            }

            $('#formDelete').submit(async function(e) {
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
                        location.reload()
                    } else {
                        toastr.warning(data.message)
                    }
                } catch (error) {
                    toastr.error(error.message)
                }

                this.reset()
                modalConfirmClose()
                loadingButton(false, '#formSubmit', 'Delete')
            })

        })
    </script>
@endpush
