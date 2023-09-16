<?php

namespace App\Http\Controllers\Landing\Macro;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class DataMacroController extends Controller
{
    public function __construct() {
        App::setLocale(Route::current()->parameter('locale') ?? 'id');
    }
    
    public function index(Request $request)
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();

        $year = $request->year ?? $tahun[0]->tahun ?? '';

        $bulan = VariableData::select('bulan')
            ->where('tahun', '=', $year)
            ->where('bulan', '<=', 12)
            ->whereIn('variable_masters_id', [6,7,8,9])
            ->groupBy('bulan')
            ->get();

        $data = VariableData::where('tahun', '=', $year)
            ->whereIn('variable_masters_id', [6,7,8,9])
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

        return view('landing.macro.data', compact('tahun', 'bulan', 'data'));
    }

    public function getByYear(Request $request)
    {
        try {
            if (!$request->year) {
                return response()->json(['code' => 400, 'message' => 'Data tahun kosong', 'data' => null], 200);
            }

            $bulan = VariableData::select('bulan')
                ->whereIn('variable_masters_id', [6,7,8,9])
                ->where('tahun', '=', $request->year)
                ->groupBy('bulan')
                ->get();

            $data = VariableData::where('tahun', '=', $request->year)
                ->whereIn('variable_masters_id', [6,7,8,9])
                ->orderBy('tahun', 'asc')
                ->orderBy('bulan', 'asc')
                ->orderBy('variable_masters_id', 'asc')
                ->get();

            return response()->json(['code' => 200, 'message' => 'OK', 'bulan' => $bulan, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }
}
