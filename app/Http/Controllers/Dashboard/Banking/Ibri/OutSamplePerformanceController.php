<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use App\Models\VariableData;

class OutSamplePerformanceController extends Controller
{
    public function indexUpper()
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->get()
            ->toArray();
        return view('dashboard.bank.ibri.outsampleperf.upper.index', compact('variable', 'tahun'));
    }

    public function indexLower()
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->get()
            ->toArray();
        return view('dashboard.bank.ibri.outsampleperf.lower.index', compact('variable', 'tahun'));
    }
}
