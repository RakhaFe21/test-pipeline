<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use Illuminate\Http\Request;

class BankBasedYearController extends Controller
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

        return view('dashboard.bank.ibri.basedyear.index', compact('tahun', 'bulan', 'data'));
    }
}
