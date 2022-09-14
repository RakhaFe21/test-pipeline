<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Banking\BankVariableController;
use App\Http\Controllers\Dashboard\Banking\Data\BankDataController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankTheoreticalController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankTransformingController;
use App\Http\Controllers\Landing\{HomeController, IntegrationController, ProfileController, TentangKamiController};
use App\Http\Controllers\Landing\Bank\{DataController, TheheatmapController, TheoriticalController, VariableController, VisualizationController};
use App\Http\Controllers\Landing\Macro\{DataMacroController, TheheatmapMacroController, TheoriticalMacroController, VariableMacroController, VisualizationMacroController};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [TentangKamiController::class, 'index'])->name('tentang.kami');
Route::get('/integration', [IntegrationController::class, 'index'])->name('integration');

Route::prefix('auth')->middleware(['guest'])->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.resetPassword');
    Route::get('change-password/{token}', [AuthController::class, 'changePassword'])->name('auth.changePassword');
    Route::post('change-password', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');
});

Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
    Route::post('upload', [ProfileController::class, 'upload'])->name('profile.upload');
    Route::post('update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('delete', [ProfileController::class, 'delete'])->name('profile.delete');
});

Route::prefix('bank')->group(function () {
    Route::get('variable', [VariableController::class, 'index'])->name('bank.variable');
    Route::get('data', [DataController::class, 'index'])->name('bank.data');
    Route::post('data', [DataController::class, 'getByYear'])->name('bank.data.getByYear');
    Route::get('theoritical', [TheoriticalController::class, 'index'])->name('bank.theoritical');
    Route::get('theheatmap', [TheheatmapController::class, 'index'])->name('bank.theheatmap')->middleware('check');
    Route::get('visualization', [VisualizationController::class, 'index'])->name('bank.visualization')->middleware('check');
});

Route::prefix('macro')->group(function () {
    Route::get('variable', [VariableMacroController::class, 'index'])->name('macro.variable');
    Route::get('data', [DataMacroController::class, 'index'])->name('macro.data');
    Route::get('theoritical', [TheoriticalMacroController::class, 'index'])->name('macro.theoritical');
    Route::get('theheatmap', [TheheatmapMacroController::class, 'index'])->name('macro.theheatmap')->middleware('check');
    Route::get('visualization', [VisualizationMacroController::class, 'index'])->name('macro.visualization')->middleware('check');
});

Route::prefix('dashboard')->middleware(['auth', 'redirect'])->name('dashboard.')->group(function () {
    Route::get('home', [DashboardController::class, 'index'])->name('home');
    Route::get('bank/variable', [BankVariableController::class, 'index'])->name('bank.variable');

    Route::get('bank/data', [BankDataController::class, 'index'])->name('bank.data');
    Route::post('bank/data', [BankDataController::class, 'getByYear'])->name('bank.data.getByYear');
    Route::get('bank/data/create', [BankDataController::class, 'create'])->name('bank.data.create');
    Route::post('bank/data/create', [BankDataController::class, 'store'])->name('bank.data.store');
    Route::get('bank/data/edit/{tahun}/{bulan}', [BankDataController::class, 'edit'])->name('bank.data.edit');
    Route::post('bank/data/update', [BankDataController::class, 'update'])->name('bank.data.update');
    Route::post('bank/data/delete', [BankDataController::class, 'delete'])->name('bank.data.delete');

    Route::get('bank/ibri/theoretical', [BankTheoreticalController::class, 'index'])->name('bank.ibri.theoretical');

    Route::get('bank/ibri/transforming', [BankTransformingController::class, 'index'])->name('bank.ibri.transforming');
});
