<?php

namespace App\Http\Controllers\Dashboard\Banking\Data;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankDataController extends Controller
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

        return view('dashboard.bank.data.index', compact('tahun', 'bulan', 'data'));
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

    public function create()
    {
        return view('dashboard.bank.data.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|numeric',
            'month' => 'required|numeric',
            'npf' => 'required|numeric',
            'car' => 'required|numeric',
            'ipr' => 'required|numeric',
            'fdr' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Validate' . $request->year, 'data' => $validator->errors()], 200);
        }

        $check = VariableData::where('tahun', '=', $request->year)
            ->where('bulan', '=', $request->month)
            ->get();

        if ($check->count() > 0) {
            return response()->json(['code' => 500, 'message' => 'Data tahun ' . $request->year . ' bulan ' . $request->month . ' sudah ada', 'data' => null], 200);
        }

        DB::beginTransaction();

        try {
            $npf = new VariableData;
            $npf->negara_masters_id = 1;
            $npf->variable_masters_id = 1;
            $npf->tahun = $request->year;
            $npf->bulan = $request->month;
            $npf->value = $request->npf;
            $npf->save();

            $car = new VariableData;
            $car->negara_masters_id = 1;
            $car->variable_masters_id = 2;
            $car->tahun = $request->year;
            $car->bulan = $request->month;
            $car->value = $request->car;
            $car->save();

            $ipr = new VariableData;
            $ipr->negara_masters_id = 1;
            $ipr->variable_masters_id = 3;
            $ipr->tahun = $request->year;
            $ipr->bulan = $request->month;
            $ipr->value = $request->ipr;
            $ipr->save();

            $fdr = new VariableData;
            $fdr->negara_masters_id = 1;
            $fdr->variable_masters_id = 4;
            $fdr->tahun = $request->year;
            $fdr->bulan = $request->month;
            $fdr->value = $request->fdr;
            $fdr->save();

            DB::commit();

            return response()->json(['code' => 200, 'message' => 'Berhasil menyimpan data', 'data' => null], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }

    public function edit(Request $request)
    {

        $data = VariableData::where('tahun', '=', $request->tahun)
            ->where('bulan', '=', $request->bulan)
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

        return view('dashboard.bank.data.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npf' => 'required|numeric',
            'car' => 'required|numeric',
            'ipr' => 'required|numeric',
            'fdr' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Validate', 'data' => $validator->errors()], 200);
        }

        DB::beginTransaction();

        try {
            VariableData::where('tahun', request()->tahun)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 1)
                ->update(['value' => $request->npf]);

            VariableData::where('tahun', request()->tahun)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 2)
                ->update(['value' => $request->car]);

            VariableData::where('tahun', request()->tahun)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 3)
                ->update(['value' => $request->ipr]);

            VariableData::where('tahun', request()->tahun)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 4)
                ->update(['value' => $request->fdr]);

            DB::commit();

            return response()->json(['code' => 200, 'message' => 'Berhasil menyimpan data', 'data' => null], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }

    public function delete(Request $request)
    {
    }
}
