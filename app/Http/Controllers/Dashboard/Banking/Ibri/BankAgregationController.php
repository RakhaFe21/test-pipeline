<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Service\IndexServiceController;
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
        $this->indexService = new IndexServiceController($this->country->id);
    }

    public function index(Request $request)
    {
        $this->indexService->transform_to_index();
        $weight = VariableWeight::select('variable_masters_id', 'weight', 'based_year')
            ->where('negara_masters_id', $this->country->id)
            ->orderBy('variable_masters_id', 'asc')
            ->get()->each(function ($item, $key) {
                $item->weight = round($item->weight, 3);
            });

        $tahun = VariableData::select('tahun')
            ->where('negara_masters_id', $this->country->id)
            ->groupBy('tahun')
            ->get();

        $bulan = VariableData::select('bulan')
            ->where('negara_masters_id', $this->country->id)
            ->groupBy('bulan')
            ->get();

        $data = VariableData::select('tahun', 'bulan', 'value_index')
        ->where('negara_masters_id', $this->country->id)
        ->whereNotIn('variable_masters_id', [5,6,7,8,9,10])
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
        ->where('variable_masters_id', 5)
        ->orderBy('tahun', 'asc')
        ->orderBy('bulan', 'asc')
        ->get();

        foreach ($composites as $key => $value) {
            array_push($arr_composite, round($value->value_index, 2));
        }

        return view('dashboard.bank.ibri.agregation.index', compact('weight', 'tahun', 'bulan', 'data', 'arr_composite'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'data' => 'required|json'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid Data', 'data' => $validator->errors()], 200);
        }

        $update = DB::transaction(function () use ($request) {
            try {
                $json = json_decode($request->data, false);

                foreach ($json as $data) {

                    $check = VariableData::where('negara_masters_id', 1)
                        ->where('variable_masters_id', 5)
                        ->where('tahun', $data[0])
                        ->where('bulan', $data[1])
                        ->get();

                    if ($check->count() > 0) {

                        VariableData::where('negara_masters_id', 1)
                            ->where('variable_masters_id', 5)
                            ->where('tahun', $data[0])
                            ->where('bulan', $data[1])
                            ->update(['value' => $data[6]]);
                    } else {
                        VariableData::insert(['negara_masters_id' => 1, 'variable_masters_id' => 5, 'tahun' => $data[0], 'bulan' => $data[1], 'value' => $data[6], 'created_at' => Carbon::now()]);
                    }
                }

                return ['code' => 200, 'message' => "Data insert successfully", 'data' => null];
            } catch (Exception $e) {
                return ['code' => 500, 'message' => $e->getMessage(), 'data' => $json];
            }
        });

        return response()->json($update, 200);
    }
}
