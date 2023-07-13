<?php

namespace App\Http\Controllers\Landing\Macro;

use App\Http\Controllers\Controller;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use App\Models\VariableMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class VisualizationMacroController extends Controller
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
        return view('landing.macro.visualization', compact('variable', 'tahun', 'avg'));
    }
}
