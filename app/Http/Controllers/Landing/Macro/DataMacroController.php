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
            ->groupBy('bulan')
            ->get();

        $data = VariableData::where('tahun', '=', $year)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

        return view('landing.macro.data', compact('tahun', 'bulan', 'data'));
    }
}
