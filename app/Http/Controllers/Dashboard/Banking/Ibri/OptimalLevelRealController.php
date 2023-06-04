<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use App\Models\VariableData;
use App\Models\AdditionalData;
use App\Http\Controllers\Service\SpreadsheetServiceController;

class OptimalLevelRealController extends Controller
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
        return view('dashboard.bank.ibri.optimallevelreal.index', compact('variable', 'tahun', 'avg'));
    }

    public function getStdev(Request $request)
    {   $array = [];
        foreach ($request->array as $key => $value) {
            array_push($array, floatval($value));
        }
        return SpreadsheetServiceController::STDEV($array);
    }

    public function getData(Request $request)
    {
        $data =  VariableData::where('variable_masters_id', $request->variable)->get();
        
        return ['code' => 200, 'message' => 'success', 'data' => $data];
    }
}
