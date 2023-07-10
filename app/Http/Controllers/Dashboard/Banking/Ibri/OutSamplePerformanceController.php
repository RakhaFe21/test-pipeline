<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

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
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
           ->whereNotIn('variable_masters_id', [6,7,8,9,10])
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereNotIn('id', [6,7,8,9,10])
            ->get()
            ->toArray();
        return view('dashboard.bank.ibri.outsampleperf.upper.index', compact('variable', 'tahun'));
    }

    public function indexLower()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
           ->whereNotIn('variable_masters_id', [6,7,8,9,10])
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereNotIn('id', [6,7,8,9,10])
            ->get()
            ->toArray();
        return view('dashboard.bank.ibri.outsampleperf.lower.index', compact('variable', 'tahun'));
    }
}
