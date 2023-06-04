<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use App\Models\VariableData;
use App\Models\AdditionalData;

class HeatMapController extends Controller
{
    public function index()
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->get()
            ->toArray();
        $avg =  AdditionalData::where([
            ['name' , '=', 'average_treshold'],
            ['negara_masters_id' , '=', '1'],
            ['jenis' , '=', 'a']
        ])->first();
        $avg = round($avg->value, 2);
        return view('dashboard.bank.ibri.settingtheheatmap.index', compact('variable', 'tahun', 'avg'));
    }
}
