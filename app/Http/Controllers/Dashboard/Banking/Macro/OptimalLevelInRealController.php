<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use App\Models\VariableData;
use App\Models\AdditionalData;
use App\Http\Controllers\Service\SpreadsheetServiceController;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class OptimalLevelInRealController extends Controller
{
    private $country;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }
    
    
    public function index()
    {
        $tahun = VariableData::select('tahun', 'negara_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereIn('id', [6,7,8,9,10])
            ->get()
            ->toArray();
        $avg =  AdditionalData::where([
            ['name' , '=', 'average_treshold'],
            ['negara_masters_id' , '=', $this->country->id],
            ['jenis' , '=', 'b']
        ])->first();
        $avg = @round($avg->value, 2);
        return view('dashboard.bank.macro.optimallevelreal.index', compact('variable', 'tahun', 'avg'));
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
        $data =  VariableData::where('variable_masters_id', $request->variable)->whereIn('variable_masters_id', [6,7,8,9,10])->where('negara_masters_id', $this->country->id)->get();
        
        return ['code' => 200, 'message' => 'success', 'data' => $data];
    }
}
