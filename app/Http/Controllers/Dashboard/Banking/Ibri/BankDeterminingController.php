<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankDeterminingController extends Controller
{
    public function index()
    {
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

        return view('dashboard.bank.ibri.determining.index', compact('tahun', 'bulan', 'data'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'npf' => 'required|numeric',
            'car' => 'required|numeric',
            'ipr' => 'required|numeric',
            'fdr' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid Data', 'data' => $validator->errors()], 200);
        }

        $select = VariableWeight::where('negara_masters_id', 1)
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->get();

        if (!$select->count() > 0) {
            return response()->json(['code' => 400, 'message' => 'Variable Weight Data Not Found', 'data' => $validator->errors()], 200);
        }

        $update = DB::transaction(function () use ($request) {
            try {
                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 1)
                    ->update(['weight' => $request->npf]);

                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 2)
                    ->update(['weight' => $request->car]);

                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 3)
                    ->update(['weight' => $request->ipr]);

                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 4)
                    ->update(['weight' => $request->fdr]);

                return ['code' => 200, 'message' => "Data saved successfully", 'data' => null];
            } catch (Exception $e) {
                return ['code' => 500, 'message' => $e->getMessage(), 'data' => null];
            }
        });

        return response()->json($update, 200);
    }
}
