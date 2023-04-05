<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use App\Models\VariableData;

class OptimalLevelIndexController extends Controller
{
    public function index()
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->get()
            ->toArray();
        return view('dashboard.bank.ibri.optimallevelindex.index', compact('variable', 'tahun'));
    }
}
