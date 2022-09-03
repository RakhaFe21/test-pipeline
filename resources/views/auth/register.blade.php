@extends('template.auth')

@section('left-content')
    <div class="w-full max-w-[265px]">
        <div class="flex flex-col gap-2 mb-5">
            <h2 class="text-black-1 font-semibold text-2xl">Buat Akun</h2>
            <p class="text-black-1 font-normal text-xs">Silahkan buat akun untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-5">
                <label for="name" class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5 @error('name') border-red-500 @enderror" placeholder="Nama" required>
                @error('name')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="username" class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5 @error('username') border-red-500 @enderror" placeholder="Username" required>
                @error('username')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5 @error('email') border-red-500 @enderror" placeholder="Email" required>
                @error('email')
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
            <div class="mb-5">
                <div class="mb-6">
                    <label for="password_confirmation" class="block mb-2 text-xs font-normal text-gray-900 dark:text-gray-300">Password Confirmation</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-1 focus:border-blue-1 block w-full p-2.5" placeholder="•••••••••" required>
                </div>
            </div>
            <button id="submit" type="submit" class="text-white w-full bg-blue-1 hover:bg-blue-2 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-4 focus:outline-none">Buat Akun</button>
            <div class="flex w-full justify-center">
                <span class="text-xs">Sudah memiliki akun?</span><a href="{{ route('login') }}" class="text-xs text-blue-1 ml-2 hover:text-blue-2">Log In</a>
            </div>
        </form>
    </div>
@endsection

@section('right-content')
    <img src="{{ asset('img/secure-login.png') }}" alt="">
@endsection
