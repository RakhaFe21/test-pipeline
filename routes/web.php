<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Banking\BankVariableController;
use App\Http\Controllers\Dashboard\Banking\Data\BankDataController;
use App\Http\Controllers\Dashboard\Banking\Data\NullHypothesisDataController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankAgregationController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankTheoreticalController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankTransformingController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankBasedYearController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankDeterminingController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankFactorAnalysisController;
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
    Route::post('bank/ibri/transforming', [BankTransformingController::class, 'store'])->name('bank.ibri.transforming.store');

    Route::get('bank/ibri/basedYear', [BankBasedYearController::class, 'index'])->name('bank.ibri.basedYear');
    Route::post('bank/ibri/basedYear', [BankBasedYearController::class, 'store'])->name('bank.ibri.basedYear.store');

    Route::get('bank/ibri/determining', [BankDeterminingController::class, 'index'])->name('bank.ibri.determining');
    Route::post('bank/ibri/determining', [BankDeterminingController::class, 'store'])->name('bank.ibri.determining.store');

    Route::get('bank/ibri/agregation', [BankAgregationController::class, 'index'])->name('bank.ibri.agregation');
    Route::post('bank/ibri/agregation', [BankAgregationController::class, 'store'])->name('bank.ibri.agregation.store');

    Route::get('bank/ibri/factorAnalysis', [BankFactorAnalysisController::class, 'index'])->name('bank.ibri.factorAnalysis');
    Route::post('bank/ibri/factorAnalysis', [BankFactorAnalysisController::class, 'store'])->name('bank.ibri.factorAnalysis.store');

    Route::get('bank/nullhypothesisdata', [NullHypothesisDataController::class, 'index'])->name('bank.hypothesysdata');
    Route::get('bank/nullhypothesisdata/create', [NullHypothesisDataController::class, 'create'])->name('bank.hypothesysdata.create');
    Route::post('bank/nullhypothesisdata/store', [NullHypothesisDataController::class, 'store'])->name('bank.hypothesisdata.store');
    Route::get('bank/nullhypothesisdata/edit/{grupId}/{id}', [NullHypothesisDataController::class, 'edit'])->name('bank.nullhypothesisdata.edit');
    Route::post('bank/nullhypothesisdata/update', [NullHypothesisDataController::class, 'update'])->name('bank.nullhypothesisdata.update');
    Route::post('bank/nullhypothesis/delete', [NullHypothesisDataController::class, 'destroy'])->name('bank.nullhypothesisdata.delete');
    Route::get('bank/nullhypothesisdata/variable', [NullHypothesisDataController::class,'getVariableValue'])->name('bank.nullhypothesis.variableValue');
    Route::get('bank/nullhypothesisdata/normalizedVariable', [NullHypothesisDataController::class,'getNormalizedVariableValue'])->name('bank.nullhypothesis.normalizedVariableValue');
    Route::get('bank/nullhypothesisdata/identityMatrix', [NullHypothesisDataController::class,'identityMatrix'])->name('bank.nullhypothesis.identityMatrix');
    Route::get('bank/nullhypothesisdata/identityMatrixY', [NullHypothesisDataController::class,'identityMatrixY'])->name('bank.nullhypothesis.identityMatrixY');
    Route::get('bank/nullhypothesisdata/minvers', [NullHypothesisDataController::class, 'getMinvers'])->name('bank.hypothesysdata.minvers');
    Route::get('bank/nullhypothesisdata/relationmatrix', [NullHypothesisDataController::class, 'totalRelationMatrix'])->name('bank.hypothesysdata.relationmatrix');
});
