@extends('template.auth')

@section('left-content')
    <div class="w-full max-w-[265px]">
        <div class="flex flex-col gap-2 mb-5">
            <h2 class="text-black-1 font-semibold text-2xl">Reset Password</h2>
            <p class="text-black-1 font-normal text-xs">Silahkan reset password untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('password.request') }}">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Email</label>
                <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5 @error('email') border-red-500 @enderror" placeholder="Email" required>
                @error('email')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <button id="submit" type="submit" class="text-white w-full bg-blue-1 hover:bg-blue-2 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Reset Password</button>
            <div class="flex w-full justify-center">
                <span class="text-xs">Belum memiliki akun?</span><a href="{{ route('register') }}" class="text-xs text-blue-1 ml-2 hover:text-blue-2">Buat Akun</a>
            </div>
        </form>
    </div>
@endsection

@section('right-content')
    <img src="{{ asset('img/secure-login.png') }}" alt="">
@endsection
