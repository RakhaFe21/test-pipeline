<?php

namespace App\Http\Controllers\Landing\Bank;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use Exception;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $year = $request->year ?? $tahun[0]->tahun ?? '';

        $bulan = VariableData::select('bulan')
            ->where('tahun', '=', $year)
            ->groupBy('bulan')
            ->get();

        $data = VariableData::where('tahun', '=', $year)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

        return view('landing.bank.data', compact('tahun', 'bulan', 'data'));
    }

    public function getByYear(Request $request)
    {
        try {
            if (!$request->year) {
                return response()->json(['code' => 400, 'message' => 'Data tahun kosong', 'data' => null], 200);
            }

            $bulan = VariableData::select('bulan')
                ->where('tahun', '=', $request->year)
                ->groupBy('bulan')
                ->get();

            $data = VariableData::where('tahun', '=', $request->year)
                ->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->orderBy('variable_masters_id', 'asc')
                ->get();

            return response()->json(['code' => 200, 'message' => 'OK', 'bulan' => $bulan, 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }
}
