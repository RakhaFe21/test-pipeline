@extends('template.dashboard')

@section('content')
    <section class="p-5">
        <div class="fle flex-col w-full mb-6">
            <h1 class="text-3xl font-medium">Setting Treshold</h1>
            <div class="flex flex-row gap-2 mt-1">
                <span>Edit Null Hypothesis</span>
            </div>
        </div>

        <div class="block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <form id="formCreate" method="POST" action="{{ route('dashboard.bank.nullhypothesisdata.update', ['code'  => \Route::current()->parameter('code'), 'groupId' => $grupId, 'dataId1' => $data['nullId1'], 'dataId2' => $data['nullId2']]) }}">
                <div class="flex">
                    <div class="flex-1 w-64 mr-2">
                        <span class="text-lg">Null Hypothesis 1</span>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">Variabel</label>
                            <select id="variable_1a" name="variable_1a"
                                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[100px] p-2"
                                required>
                                @foreach ($var as $vItem)
                                    <option value="{{ $vItem->nama_variable }}" {{ (strtoupper($vItem->nama_variable) == $data['nullA_1'])?'selected':'' }}>{{ strtoupper($vItem->nama_variable) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="my-4">
                            <p class="text-sm">Does not Granger Cause </p>
                        </div>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">Variabel</label>
                            <select id="variable_1b" name="variable_1b"
                                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[100px] p-2"
                                required>
                                @foreach ($var as $vItem)
                                    <option value="{{ $vItem->nama_variable }}" {{ (strtoupper($vItem->nama_variable) == $data['nullA_2'])?'selected':'' }}>{{ strtoupper($vItem->nama_variable) }}</option>
                                @endforeach
                            </select>
                            <span id="variable_1b_msg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">Obs</label>
                            <input id="obs" type="text" name="obs" value="{{ $data['obs'] }}" placeholder="Masukkan Data"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                                required>
                            <span id="obsMsg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">F-Statistic</label>
                            <input id="fStatistic1" type="text" name="fStatistic1" value="{{ $data['fStatic1'] }}"
                                placeholder="Masukkan Data"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                                required>
                            <span id="fStatistic1Msg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">Prob</label>
                            <input id="prob1" type="text" name="prob1" value="{{ $data['prob1'] }}" placeholder="Masukkan Data"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5">
                            <span id="prob1Msg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                    </div>
                    <div class="flex-1 w-64">
                        <span class="text-lg">Null Hypothesis 2</span>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">Variabel</label>
                            <select id="variable_2a" name="variable_2a"
                                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[100px] p-2"
                                required>
                                @foreach ($var as $vItem)
                                    <option value="{{ $vItem->nama_variable }}" {{ (strtoupper($vItem->nama_variable) == $data['nullB_1'])?'selected':'' }}>{{ strtoupper($vItem->nama_variable) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="my-4">
                            <p class="text-sm">Does not Granger Cause </p>
                        </div>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">Variabel</label>
                            <select id="variable_2b" name="variable_2b"
                                class="bg-gray-50 border border-ds-gray text-sm rounded-lg focus:ring-ds-gray focus:border-ds-gray block w-[100px] p-2"
                                required>
                                @foreach ($var as $vItem)
                                    <option value="{{ $vItem->nama_variable }}" {{ (strtoupper($vItem->nama_variable) == $data['nullB_2'])?'selected':'' }}>{{ strtoupper($vItem->nama_variable) }}</option>
                                @endforeach
                            </select>
                            <span id="variable_2b_msg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">F-Statistic</label>
                            <input id="fStatistic2" type="text" name="fStatistic2" value="{{ $data['fStatic2'] }}"
                                placeholder="Masukkan Data"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5"
                                required>
                            <span id="fStatistic2Msg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="my-4">
                            <label class="block mb-2 text-sm font-normal">Prob</label>
                            <input id="prob2" type="text" name="prob2" value="{{ $data['prob2'] }}" placeholder="Masukkan Data"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-xl focus:ring-ds-gray focus:border-ds-gray block w-full p-2.5">
                            <span id="prob2Msg" class="hidden mt-2 text-xs text-red-500"></span>
                        </div>
                        <div class="flex flex-row justify-start gap-4">
                            <button id="cancel" type="button"
                                class="bg-gray-50 hover:bg-gray-100 border border-ds-gray focus:ring-ds-gray focus:border-ds-gray font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>
                            <button id="formSubmit" type="submit"
                                class="text-white bg-ds-blue hover:bg-ds-blue-hover font-medium rounded-lg text-sm px-5 py-2.5">Save
                                Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            /* Check if value same */
            $('#variable_1b').change(function () {
                if($(this).val() == $('#variable_1a').val()) {
                    $('#variable_1b').addClass('border-red-500')
                    $('#variable_1b_msg').addClass('font-bold').removeClass('hidden').text('Variables cannot be same')
                    $('#formSubmit').attr('disabled',true)
                } else {
                    $('#variable_1b').removeClass('border-red-500')
                    $('#variable_1b_msg').removeClass('font-bold').addClass('hidden').text('Variables cannot be same')
                    $('#formSubmit').attr('disabled',false)
                }
            });

            $('#variable_2b').change(function () {
                if($(this).val() == $('#variable_1b').val()) {
                    $('#variable_2b').addClass('border-red-500')
                    $('#variable_2b_msg').addClass('font-bold').removeClass('hidden').text('Variables cannot be same')
                    $('#formSubmit').attr('disabled',true)
                } else {
                    $('#variable_2b').removeClass('border-red-500')
                    $('#variable_2b_msg').removeClass('font-bold').addClass('hidden').text('Variables cannot be same')
                    $('#formSubmit').attr('disabled',false)
                }
            });

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

                    $('#npf').removeClass('border-red-500')
                    $('#npfMsg').addClass('hidden')
                    $('#car').removeClass('border-red-500')
                    $('#carMsg').addClass('hidden')
                    $('#ipr').removeClass('border-red-500')
                    $('#iprMsg').addClass('hidden')
                    $('#fdr').removeClass('border-red-500')
                    $('#fdrMsg').addClass('hidden')

                    if (data.code === 200) {
                        toastr.success(data.message)
                        this.reset()
                    } else if (data.code === 400) {
                        if (data.data.fStatistic1) {
                            $('#fStatistic1').addClass('border-red-500')
                            $('#fStatistic1Msg').removeClass('hidden').text(data.data.fStatistic1[0])
                        }
                        if (data.data.fStatistic2) {
                            $('#fStatistic2').addClass('border-red-500')
                            $('#fStatistic2Msg').removeClass('hidden').text(data.data.fStatistic2[0])
                        }
                        if (data.data.prob1) {
                            $('#prob1').addClass('border-red-500')
                            $('#prob1Msg').removeClass('hidden').text(data.data.prob1[0])
                        }
                        if (data.data.prob2) {
                            $('#prob2').addClass('border-red-500')
                            $('#prob2Msg').removeClass('hidden').text(data.data.prob2[0])
                        }
                        if (data.data.obs) {
                            $('#obs').addClass('border-red-500')
                            $('#obsMsg').removeClass('hidden').text(data.data.obs[0])
                        }
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
                window.location = '{{ route('dashboard.bank.hypothesysdata', ['code'  => \Route::current()->parameter('code')]) }}'
            })

        })
    </script>
@endpush
