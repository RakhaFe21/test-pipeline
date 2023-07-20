<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use App\Models\NegaraMaster;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use App\Models\VariableData;
use Illuminate\Support\Facades\Route;

class OutSamplePerformanceController extends Controller
{
    private $country;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }
    
    public function indexUpper()
    {
        $tahun = VariableData::select('tahun', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
        ->groupBy('tahun')
        ->get();
        
        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereNotIn('id', [1,2,3,4,5])
            ->get()
            ->toArray();
        return view('dashboard.bank.macro.outsampleperf.upper.index', compact('variable', 'tahun'));
    }

    public function indexLower()
    {
        $tahun = VariableData::select('tahun', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
        ->groupBy('tahun')
        ->get();
        
        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereNotIn('id', [1,2,3,4,5])
            ->get()
            ->toArray();
        return view('dashboard.bank.macro.outsampleperf.lower.index', compact('variable', 'tahun'));
    }
}
