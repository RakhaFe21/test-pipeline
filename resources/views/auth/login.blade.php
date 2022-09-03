@extends('template.auth')

@section('left-content')
    <div class="w-full max-w-[265px]">
        <div class="flex flex-col gap-2 mb-5">
            <h2 class="text-black-1 font-semibold text-2xl">Log In</h2>
            <p class="text-black-1 font-normal text-xs">Silahkan melakukan login untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-5">
                <label for="username" class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Username</label>
                <input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5 @error('username') border-red-500 @enderror" placeholder="Input Username" required>
                @error('username')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Password</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5 @error('password') border-red-500 @enderror" placeholder="•••••••••" required>
                </div>
                @error('password')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-row justify-between">
                <div class="flex items-center mb-4">
                    <input id="remember" type="checkbox" name="remember" value="" class="w-4 h-4 text-blue-1 bg-gray-100 rounded border-gray-300 focus:ring-blue-1 focus:ring-2">
                    <label for="remember" class="ml-2 text-black-1 font-normal text-xs">Ingat selama 30 hari</label>
                </div>
                <a href="forgot-password" class="text-blue-1 font-normal text-xs hover:text-blue-2">Lupa Password</a>
            </div>
            <button id="submit" type="submit" class="text-white w-full bg-blue-1 hover:bg-blue-2 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Login</button>
            <div class="flex w-full justify-center">
                <span class="text-xs">Belum memiliki akun?</span><a href="{{ route('register') }}" class="text-xs text-blue-1 ml-2 hover:text-blue-2">Buat Akun</a>
            </div>
        </form>
    </div>
@endsection

@section('right-content')
    <img src="{{ asset('img/secure-login.png') }}" alt="">
@endsection
