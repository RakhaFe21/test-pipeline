<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use App\Models\VariableData;
use App\Models\AdditionalData;
use App\Http\Controllers\Service\SpreadsheetServiceController;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class OptimalLevelRealController extends Controller
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
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
           ->whereNotIn('variable_masters_id', [6,7,8,9,10])
            ->groupBy('tahun')
            ->get();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereNotIn('id', [6,7,8,9,10])
            ->get()
            ->toArray();
        $avg =  AdditionalData::where([
            ['name' , '=', 'average_treshold'],
            ['negara_masters_id' , '=', $this->country->id],
            ['jenis' , '=', 'a']
        ])->first();
        $avg = @round($avg->value, 2);
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
        $data =  VariableData::where('variable_masters_id', $request->variable)->where('negara_masters_id', $this->country->id)->get();
        
        return ['code' => 200, 'message' => 'success', 'data' => $data];
    }
}
