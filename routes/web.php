<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/reset-password', [AuthController::class, 'resetPassword'])->name('auth.resetPassword');
Route::get('auth/change-password/{token}', [AuthController::class, 'changePassword'])->name('auth.changePassword');
Route::post('auth/change-password', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');

Route::prefix('/')->middleware(['auth'])->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
});

Route::prefix('dashboard')->middleware(['auth', 'redirect'])->name('dashboard.')->group(function () {
    Route::get('home', function () {
        return view('dashboard.home');
    });
});
