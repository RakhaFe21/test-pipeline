<?php

	use App\Http\Controllers\Auth\AuthController;
	use App\Http\Controllers\Dashboard\Banking\BankVariableController;
	use App\Http\Controllers\Dashboard\Banking\Data\BankDataController;
use App\Http\Controllers\Dashboard\Banking\Data\MacroDataController;
use App\Http\Controllers\Dashboard\Banking\Ibri\BankAgregationController;
	use App\Http\Controllers\Dashboard\Banking\Ibri\BankBasedYearController;
	use App\Http\Controllers\Dashboard\Banking\Ibri\BankDeterminingController;
	use App\Http\Controllers\Dashboard\Banking\Ibri\BankFactorAnalysisController;
	use App\Http\Controllers\Dashboard\Banking\Ibri\BankTheoreticalController;
	use App\Http\Controllers\Dashboard\Banking\Ibri\BankTransformingController;
	use App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\SignalingTresholdController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\SampleModelController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\OutSampleController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\OutSamplePerformanceController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\OptimalLevelIndexController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\OptimalLevelRealController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\HeatMapController;
    use App\Http\Controllers\Dashboard\Banking\Ibri\VisualizationController as IbriVisualizationController;
	use App\Http\Controllers\Dashboard\DashboardController;
	use App\Http\Controllers\Landing\{HomeController, IntegrationController, ProfileController, TentangKamiController};
	use App\Http\Controllers\Landing\Bank\{DataController,
		TheheatmapController,
		TheoriticalController,
		VariableController,
		VisualizationController};
	use App\Http\Controllers\Landing\Macro\{DataMacroController,
		TheheatmapMacroController,
		TheoriticalMacroController,
		VariableMacroController,
		VisualizationMacroController};
	use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Dashboard\Banking\Macro\{
        BankTheoriticalController as MacroBankTheoriticalController,
        BankTransformingController as MacroBankTransformingController,
        BankBasedYearController as MacrobankBasedYearController,
        BankDeterminingController as MacroBankDeterminingController,
        BankAgregationController as MacroBankAgregationController,
        BankFactorAnalysisController as MacroBankFactorAnalysisController,
        NullHypothesisDataController as MacroNullHypothesisDataController,
        SignalingTresholdController as MacroSignalingTresholdController,
        SampleModelController as MacroSampleModelController,
        OutSampleController as MacroOutSampleController,
        OutSamplePerformanceController as MacroOutSamplePerformanceController,
        OptimalLevelInIndexController as MacroOptimalLevelInIndexController,
        OptimalLevelInRealController as MacroOptimalLevelInRealController,
        HeatMapController as MacroHeatMapController,
        VisualizationController as MacroVisualizationController
        };
use App\Http\Controllers\Dashboard\IntegrasiBankMacro\{
    PerformanceController,
    SettingCompositeIndex,
    SignalingController, VisualizationController as IntegrasiBankMacroVisualizationController};
use App\Http\Controllers\Dashboard\NegaraController;
use App\Http\Controllers\Dashboard\UserController;


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
    Route::get('theheatmap/{code}', [TheheatmapController::class, 'index'])->name('bank.theheatmap')->middleware('check');
    Route::get('visualization/{code}', [VisualizationController::class, 'index'])->name('bank.visualization')->middleware('check');
});

Route::prefix('macro')->group(function () {
    Route::get('variable', [VariableMacroController::class, 'index'])->name('macro.variable');
    Route::get('data', [DataMacroController::class, 'index'])->name('macro.data');
    Route::get('theoritical', [TheoriticalMacroController::class, 'index'])->name('macro.theoritical');
    Route::get('theheatmap/{code}', [TheheatmapMacroController::class, 'index'])->name('macro.theheatmap')->middleware('check');
    Route::get('visualization/{code}', [VisualizationMacroController::class, 'index'])->name('macro.visualization')->middleware('check');
});

Route::prefix('{code}')->group(function() {
    Route::prefix('dashboard')->middleware(['auth', 'redirect'])->name('dashboard.')->group(function () {
        Route::get('home', [DashboardController::class, 'index'])->name('home');
        Route::get('bank/variable', [BankVariableController::class, 'index'])->name('bank.variable');
    
        Route::get('bank/data', [BankDataController::class, 'index'])->name('bank.data');
        Route::post('bank/data', [BankDataController::class, 'getByYear'])->name('bank.data.getByYear');
        Route::get('bank/data/create', [BankDataController::class, 'create'])->name('bank.data.create');
        Route::post('bank/data/create', [BankDataController::class, 'store'])->name('bank.data.store');
        Route::get('bank/data/edit/{tahun?}/{bulan?}', [BankDataController::class, 'edit'])->name('bank.data.edit');
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
        Route::get('bank/nullhypothesisdata/matrix', [NullHypothesisDataController::class, 'matrix'])->name('bank.hypothesysdata.matrix');
        Route::get('bank/nullhypothesisdata/average', [NullHypothesisDataController::class, 'averageTreshold'])->name('bank.hypothesysdata.average');
    
        Route::get('bank/ibri/signaling/upper', [SignalingTresholdController::class, 'indexUpper'])->name('bank.ibri.signaling.upper');
        Route::get('bank/ibri/signaling/lower', [SignalingTresholdController::class, 'indexLower'])->name('bank.ibri.signaling.lower');
        Route::get('bank/ibri/signaling/upper/data', [SignalingTresholdController::class, 'dataUpper'])->name('bank.ibri.signaling.upper.data');
        Route::get('bank/ibri/signaling/lower/data', [SignalingTresholdController::class, 'dataLower'])->name('bank.ibri.signaling.lower.data');
    
        Route::get('bank/ibri/sample/upper', [SampleModelController::class, 'indexUpper'])->name('bank.ibri.sample.upper');
        Route::get('bank/ibri/sample/lower', [SampleModelController::class, 'indexLower'])->name('bank.ibri.sample.lower');
        Route::get('bank/ibri/sample/upper/data', [SampleModelController::class, 'dataUpper'])->name('bank.ibri.sample.upper.data');
        Route::get('bank/ibri/sample/lower/data', [SampleModelController::class, 'dataLower'])->name('bank.ibri.sample.lower.data');
        Route::get('bank/ibri/sample/hp', [SampleModelController::class, 'getHpFilter'])->name('bank.ibri.sample.hp');
    
        Route::get('bank/ibri/ews/upper', [OutSampleController::class, 'indexUpper'])->name('bank.ibri.ews.upper');
        Route::get('bank/ibri/ews/lower', [OutSampleController::class, 'indexLower'])->name('bank.ibri.ews.lower');
        Route::get('bank/ibri/ews/signal', [OutSampleController::class, 'signalData'])->name('bank.ibri.ews.signal');
        Route::get('bank/ibri/ews/signal/lower', [OutSampleController::class, 'signalDataLower'])->name('bank.ibri.ews.signal-lower');
    
        Route::get('bank/ibri/osp/upper', [OutSamplePerformanceController::class, 'indexUpper'])->name('bank.ibri.outsampleperf.upper');
        Route::get('bank/ibri/osp/lower', [OutSamplePerformanceController::class, 'indexLower'])->name('bank.ibri.outsampleperf.lower');
    
        Route::get('bank/ibri/optimal-index', [OptimalLevelIndexController::class, 'index'])->name('bank.ibri.optimallevelindex');
        
        Route::get('bank/ibri/optimal-real', [OptimalLevelRealController::class, 'index'])->name('bank.ibri.optimallevelreal');
        Route::get('bank/ibri/optimal-real-data', [OptimalLevelRealController::class, 'getData'])->name('bank.ibri.optimallevelreal.data');
    
        Route::get('bank/ibri/stdev', [OptimalLevelIndexController::class, 'getStdev'])->name('stdev');
    
        Route::get('bank/ibri/heat-map', [HeatMapController::class, 'index'])->name('bank.ibri.heat-map');
    
        Route::get('bank/ibri/visualization', [IbriVisualizationController::class, 'index'])->name('bank.ibri.visualization');
    
        Route::prefix('bank')->group(function () {
            Route::prefix('macro')->group(function () {
                Route::get('variable', [BankVariableController::class, 'Macroindex'])->name('bank.macro.variable');
    
                Route::get('data', [MacroDataController::class, 'index'])->name('bank.macro.data');
                Route::post('data', [MacroDataController::class, 'getByYear'])->name('bank.macro.data.getByYear');
                Route::get('data/create', [MacroDataController::class, 'create'])->name('bank.macro.data.create');
                Route::post('data/create', [MacroDataController::class, 'store'])->name('bank.macro.data.store');
                Route::get('data/edit/{tahun?}/{bulan?}', [MacroDataController::class, 'edit'])->name('bank.macro.data.edit');
                Route::post('data/update', [MacroDataController::class, 'update'])->name('bank.macro.data.update');
                Route::post('data/delete', [MacroDataController::class, 'delete'])->name('bank.macro.data.delete');
    
                Route::get('theoretical', [MacroBankTheoriticalController::class, 'index'])->name('bank.macro.theoritical');
                Route::get('transforming', [MacroBankTransformingController::class, 'index'])->name('bank.macro.transforming');
                Route::get('basedYear', [MacrobankBasedYearController::class, 'index'])->name('bank.macro.basedYear');
                Route::get('determining', [MacroBankDeterminingController::class, 'index'])->name('bank.macro.determining');
                Route::get('agregation', [MacroBankAgregationController::class, 'index'])->name('bank.macro.agregation');
                Route::get('factorAnalysis', [MacroBankFactorAnalysisController::class, 'index'])->name('bank.macro.factorAnalysis');
    
                Route::get('nullhypothesisdata', [MacroNullHypothesisDataController::class, 'index'])->name('bank.macro.hypothesysdata');
                Route::get('nullhypothesisdata/variable', [MacroNullHypothesisDataController::class,'getVariableValue'])->name('bank.macro.nullhypothesis.variableValue');
                Route::get('nullhypothesisdata/normalizedVariable', [MacroNullHypothesisDataController::class,'getNormalizedVariableValue'])->name('bank.macro.nullhypothesis.normalizedVariableValue');
                Route::get('nullhypothesisdata/identityMatrix', [MacroNullHypothesisDataController::class,'identityMatrix'])->name('bank.macro.nullhypothesis.identityMatrix');
                Route::get('nullhypothesisdata/identityMatrixY', [MacroNullHypothesisDataController::class,'identityMatrixY'])->name('bank.macro.nullhypothesis.identityMatrixY');
                Route::get('nullhypothesisdata/minvers', [MacroNullHypothesisDataController::class, 'getMinvers'])->name('bank.macro.hypothesysdata.minvers');
                Route::get('nullhypothesisdata/relationmatrix', [MacroNullHypothesisDataController::class, 'totalRelationMatrix'])->name('bank.macro.hypothesysdata.relationmatrix');
                Route::get('nullhypothesisdata/matrix', [MacroNullHypothesisDataController::class, 'matrix'])->name('bank.macro.hypothesysdata.matrix');
                Route::get('nullhypothesisdata/average', [MacroNullHypothesisDataController::class, 'averageTreshold'])->name('bank.macro.hypothesysdata.average');
                Route::get('signaling/upper', [MacroSignalingTresholdController::class, 'indexUpper'])->name('bank.macro.signaling.upper');
                Route::get('signaling/lower', [MacroSignalingTresholdController::class, 'indexLower'])->name('bank.macro.signaling.lower');
                Route::get('signaling/upper/data', [MacroSignalingTresholdController::class, 'dataUpper'])->name('bank.macro.signaling.upper.data');
                Route::get('signaling/lower/data', [MacroSignalingTresholdController::class, 'dataLower'])->name('bank.macro.signaling.lower.data');
    
                Route::get('sample/upper', [MacroSampleModelController::class, 'indexUpper'])->name('bank.macro.sample.upper');
                Route::get('sample/lower', [MacroSampleModelController::class, 'indexLower'])->name('bank.macro.sample.lower');
                Route::get('sample/upper/data', [MacroSampleModelController::class, 'dataUpper'])->name('bank.macro.sample.upper.data');
                Route::get('sample/lower/data', [MacroSampleModelController::class, 'dataLower'])->name('bank.macro.sample.lower.data');
                Route::get('sample/hp', [MacroSampleModelController::class, 'getHpFilter'])->name('bank.macro.sample.hp');
    
                Route::get('ews/upper', [MacroOutSampleController::class, 'indexUpper'])->name('bank.macro.ews.upper');
                Route::get('ews/lower', [MacroOutSampleController::class, 'indexLower'])->name('bank.macro.ews.lower');
                Route::get('ews/signal', [MacroOutSampleController::class, 'signalData'])->name('bank.macro.ews.signal');
                Route::get('ews/signal/lower', [MacroOutSampleController::class, 'signalDataLower'])->name('bank.macro.ews.signal-lower');
    
                Route::get('optimal-index', [MacroOptimalLevelInIndexController::class, 'index'])->name('bank.macro.optimallevelindex');
    
                Route::get('osp/upper', [MacroOutSamplePerformanceController::class, 'indexUpper'])->name('bank.macro.outsampleperf.upper');
                Route::get('osp/lower', [MacroOutSamplePerformanceController::class, 'indexLower'])->name('bank.macro.outsampleperf.lower');
    
                Route::get('optimal-real', [MacroOptimalLevelInRealController::class, 'index'])->name('bank.macro.optimallevelreal');
                Route::get('optimal-real-data', [MacroOptimalLevelInRealController::class, 'getData'])->name('bank.macro.optimallevelreal.data');
    
                Route::get('stdev', [MacroOptimalLevelInIndexController::class, 'getStdev'])->name('macro.stdev');
    
                Route::get('heat-map', [MacroHeatMapController::class, 'index'])->name('bank.macro.heat-map');
    
                Route::get('visualization', [MacroVisualizationController::class, 'index'])->name('bank.macro.visualization');
    
            }); 
        });
    
        Route::prefix('integrasi')->group(function (){
            Route::get('setting-composite-index', [SettingCompositeIndex::class, 'index'])->name('integrasi.setting-composite');
            Route::get('signaling/upper', [SignalingController::class, 'indexUpper'])->name('integrasi.signaling.upper');
            Route::get('signaling/lower', [SignalingController::class, 'indexLower'])->name('integrasi.signaling.lower');
            Route::get('signaling/upper/data', [SignalingController::class, 'dataUpper'])->name('integrasi.signaling.upper.data');
            Route::get('signaling/lower/data', [SignalingController::class, 'dataLower'])->name('integrasi.signaling.lower.data');
            Route::get('performance/upper', [PerformanceController::class, 'indexUpper'])->name('integrasi.performance.upper');
            Route::get('performance/lower', [PerformanceController::class, 'indexLower'])->name('integrasi.performance.lower');
            Route::get('performance/signal', [PerformanceController::class, 'signalData'])->name('integrasi.performance.data');
            Route::get('performance/signal/lower', [PerformanceController::class, 'signalDataLower'])->name('integrasi.performance.data-lower');
            Route::get('visualization', [IntegrasiBankMacroVisualizationController::class, 'index'])->name('integrasi.visualization');
        });

        Route::prefix('negara')->group(function (){
            Route::get('', [NegaraController::class, 'index'])->name('negara.index');
            Route::get('create', [NegaraController::class, 'create'])->name('negara.create');
            Route::post('store', [NegaraController::class, 'store'])->name('negara.store');
            Route::get('edit', [NegaraController::class, 'edit'])->name('negara.edit');
            Route::post('update', [NegaraController::class, 'update'])->name('negara.update');
            Route::post('delete', [NegaraController::class, 'delete'])->name('negara.delete');
        });

        Route::prefix('users')->group(function (){
            Route::get('', [UserController::class, 'index'])->name('user.index');
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::post('store', [UserController::class, 'store'])->name('user.store');
            Route::get('edit/{id?}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('update', [UserController::class, 'update'])->name('user.update');
            Route::post('delete', [UserController::class, 'delete'])->name('user.delete');
        });
    });
});
