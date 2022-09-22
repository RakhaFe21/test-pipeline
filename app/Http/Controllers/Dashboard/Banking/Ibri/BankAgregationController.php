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

class BankAgregationController extends Controller
{
    public function index(Request $request)
    {

        $weight = VariableWeight::select('variable_masters_id', 'weight', 'based_year')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $bulan = VariableData::select('bulan')
            ->groupBy('bulan')
            ->get();

        $data = VariableData::select('tahun', 'bulan', 'value_index')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

        return view('dashboard.bank.ibri.agregation.index', compact('weight', 'tahun', 'bulan', 'data'));
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