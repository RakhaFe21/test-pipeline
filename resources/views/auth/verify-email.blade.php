@extends('template.auth')

@section('content')
    <div class="w-full max-w-[265px]">
        <div class="flex flex-col gap-2 mb-5">
            <p class="text-black-1 font-normal text-xs">You must verify your email address, please check your email for verification link.</p>
        </div>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button id="submit" type="submit" name="resend" class="text-white w-full bg-blue-1 hover:bg-blue-2 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Confirm Password</button>
            <div class="flex w-full justify-center">
                <span class="text-xs">Belum memiliki akun?</span><a href="{{ route('register') }}" class="text-xs text-blue-1 ml-2 hover:text-blue-2">Buat Akun</a>
            </div>
        </form>
    </div>
@endsection

@section('right-content')
    <img src="{{ asset('img/secure-login.png') }}" alt="">
@endsection
