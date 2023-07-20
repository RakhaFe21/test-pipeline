<?php

namespace App\Http\Controllers\Dashboard\IntegrasiBankMacro;

use App\Http\Controllers\Controller;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SettingCompositeIndex extends Controller
{
    private $country;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }

    public function index(){

        $tahun = VariableData::select('tahun')
        ->whereIn('variable_masters_id', [5,6])
        ->where('negara_masters_id', $this->country->id)
            ->groupBy('tahun')
            ->get();

        $bulan = VariableData::select('bulan')
        ->whereIn('variable_masters_id', [5,6])
        ->where('negara_masters_id', $this->country->id)
            ->groupBy('bulan')
            ->get();

        $data = VariableData::select('tahun', 'bulan', 'value_index')
        ->whereIn('variable_masters_id', [5,6])
        ->where('negara_masters_id', $this->country->id)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get()
            ->each(function($model, $key){
                $model->value_index = round($model->value_index, 2);
            });

        return view('dashboard.integrasi_bank_macro.setting_composite.index', compact('tahun', 'bulan', 'data'));
    }
}
