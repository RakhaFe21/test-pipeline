<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankTransformingController extends Controller
{
    public function index(Request $request)
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $bulan = VariableData::select('bulan')
            ->groupBy('bulan')
            ->get();

        $data = VariableData::select('tahun', 'bulan', 'value')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

        return view('dashboard.bank.ibri.transforming.index', compact('tahun', 'bulan', 'data'));
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
