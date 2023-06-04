<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use App\Models\VariableMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Service\SpreadsheetServiceController as Excel;
use App\Http\Controllers\Service\IndexServiceController;

class BankTransformingController extends Controller
{
    public function index(Request $request)
    {
        (new IndexServiceController)->transform_to_index();
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $master = VariableData::select('tahun', 'bulan', 'value', 'variable_masters_id')
            ->where('variable_masters_id', '!=', 5)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

            $grouped = $master->groupBy('variable_masters_id')->transform(function($item, $k) {
                return $item->groupBy('tahun');
            });
            $grouped = $grouped->all();
            $arr = [];
            
            //array grouped
            foreach ($grouped as $key => $tahun) {
                $temp_id = [];
                foreach ($tahun as $keyTahun => $items) {
                    $temp_item = [];
                    foreach ($items as $keyItem => $item) {
                        $temp_item[] = $item->value;
                    }
                    array_push($temp_id, $temp_item);
                }
                array_push($arr, $temp_id);
            }

            //array stdev
            $result_stdev = [];
            foreach ($arr as $key => $index) {
                $temp_stdev = [];
                foreach ($index as $keyTahun => $items) {
                    $result = Excel::STDEV($items);
                    array_push($temp_stdev, $result);
                }
                array_push($result_stdev, $temp_stdev);
            }

            $min_npf = min($result_stdev[0]);
            $min_car = min($result_stdev[1]);
            $min_ipr = min($result_stdev[2]);
            $min_fdr = min($result_stdev[3]);

            $result_mean = [];
            foreach ($arr as $key => $indexx) {
                $temp_mean = [];
                foreach ($indexx as $keyTahun => $items) {
                    $result = Excel::average($items);
                    array_push($temp_mean, round($result, 2));
                }
                array_push($result_mean, $temp_mean);
            } 
            // dd($result_stdev);
            // $test = (4.36-3.24)/0.040;
        return view('dashboard.bank.ibri.transforming.index', [
            'years'     => $tahun,
            'stdevs'    => $result_stdev,
            'means'     => $result_mean,
            'min_npf'   => $min_npf,
            'min_car'   => $min_car,
            'min_ipr'   => $min_ipr,
            'min_fdr'   => $min_fdr
        ]);
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

                    $tahun = $data->tahun;
                    $bulan = $data->bulan;

                    VariableData::where('tahun', $tahun)
                        ->where('bulan', $bulan)
                        ->where('variable_masters_id', 1)
                        ->update(['value_index' => $data->npf]);

                    VariableData::where('tahun', $tahun)
                        ->where('bulan', $bulan)
                        ->where('variable_masters_id', 2)
                        ->update(['value_index' => $data->car]);

                    VariableData::where('tahun', $tahun)
                        ->where('bulan', $bulan)
                        ->where('variable_masters_id', 3)
                        ->update(['value_index' => $data->ipr]);

                    VariableData::where('tahun', $tahun)
                        ->where('bulan', $bulan)
                        ->where('variable_masters_id', 4)
                        ->update(['value_index' => $data->fdr]);
                }

                return ['code' => 200, 'message' => "Data updated successfully", 'data' => null];
            } catch (Exception $e) {
                return ['code' => 500, 'message' => $e->getMessage(), 'data' => $json];
            }
        });

        return response()->json($update, 200);
    }
}
