<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Landing\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/reset-password', [AuthController::class, 'resetPassword'])->name('auth.resetPassword');
Route::get('auth/change-password/{token}', [AuthController::class, 'changePassword'])->name('auth.changePassword');
Route::post('auth/change-password', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');

Route::prefix('dashboard')->middleware(['auth', 'can:is-admin'])->name('dashboard.')->group(function () {
    Route::get('home', function () {
        return view('dashboard.home');
    });
});
