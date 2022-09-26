<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\AdditionalData;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankFactorAnalysisController extends Controller
{

    public function index(Request $request)
    {

        $weight = VariableWeight::select('variable_masters.id', 'variable_masters.nama_variable', 'variable_weights.weight')
            ->join('variable_masters', 'variable_weights.variable_masters_id', '=', 'variable_masters.id')
            ->orderBy('variable_weights.weight', 'desc')
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

        return view('dashboard.bank.ibri.factoranalysis.index', compact('weight', 'tahun', 'bulan', 'data'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'consistency_ratio' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid Data', 'data' => $validator->errors()], 200);
        }

        $select = AdditionalData::where('negara_masters_id', 1)
            ->where('name', 'consistency_ratio')
            ->where('jenis', 'a')
            ->get();

        $update = DB::transaction(function () use ($request, $select) {
            try {
                $message = '';

                if ($select->count() > 0) {
                    AdditionalData::where('negara_masters_id', 1)
                        ->where('name', 'consistency_ratio')
                        ->where('jenis', 'a')
                        ->update(['value' => $request->consistency_ratio]);

                    $message = 'Data update successfully';
                } else {
                    AdditionalData::insert(['negara_masters_id' => 1, 'name' => 'consistency_ratio', 'value' => $request->consistency_ratio, 'jenis' => 'a', 'created_at' => Carbon::now()]);

                    $message = 'Data saved successfully';
                }

                return ['code' => 200, 'message' => $message, 'data' => null];
            } catch (Exception $e) {
                return ['code' => 500, 'message' => $e->getMessage(), 'data' => null];
            }
        });

        return response()->json($update, 200);
    }
}
