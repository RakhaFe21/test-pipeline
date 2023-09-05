<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Service\IndexBServiceController;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class BankAgregationController extends Controller
{
    private $country;
    private $indexService;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
        try {
            $this->indexService = new IndexBServiceController($this->country->code);
        } catch (\Throwable $th) {
            return abort(500, 'Something went wrong');
        }
    }
    public function index(Request $request)
    {
        $this->indexService->transform_to_index();
        $weight = VariableWeight::select('variable_masters_id', 'weight', 'based_year', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
        ->whereNotIn('variable_masters_id', [1,2,3,4])
            ->orderBy('variable_masters_id', 'asc')
            ->get()->each(function ($item, $key) {
                $item->weight = round($item->weight, 3);
            });

        $tahun = VariableData::select('tahun', 'negara_masters_id', 'variable_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [1,2,3,4,5,10])
            ->groupBy('tahun')
            ->get();

        $bulan = VariableData::select('bulan', 'negara_masters_id', 'variable_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [1,2,3,4,5,10])
            ->groupBy('bulan')
            ->get();

        $data = VariableData::select('tahun', 'bulan', 'value_index', 'variable_masters_id', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
        ->whereNotIn('variable_masters_id', [1,2,3,4,5,10])
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get()
            ->each(function($model, $key){
                $model->value_index = round($model->value_index, 2);
            });
        $arr_composite = [];
        $composites = VariableData::select('tahun', 'bulan', 'value_index')
        ->where('negara_masters_id', $this->country->id)
        ->where('variable_masters_id', 10)
        ->orderBy('tahun', 'asc')
        ->orderBy('bulan', 'asc')
        ->get();

        foreach ($composites as $key => $value) {
            array_push($arr_composite, round($value->value_index, 2));
        }

        return view('dashboard.bank.macro.agregation.index', compact('weight', 'tahun', 'bulan', 'data', 'arr_composite'));
    }
}
