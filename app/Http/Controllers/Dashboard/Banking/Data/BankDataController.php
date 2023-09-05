<?php

namespace App\Http\Controllers\Dashboard\Banking\Data;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\IndexServiceController;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class BankDataController extends Controller
{
    private $country;
    private $indexService;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
        try {
            $this->indexService = new IndexServiceController($this->country->id);
        } catch (\Throwable $th) {
            return abort(500, 'Something went wrong');
        }
    }
    
    public function index(Request $request)
    {
        $tahun = VariableData::select('tahun', 'negara_masters_id')
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->where('negara_masters_id', $this->country->id)
            ->groupBy('tahun')
            ->get();

        $year = $request->year ?? $tahun[0]->tahun ?? '';

        $bulan = VariableData::select('bulan', 'negara_masters_id')
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->where('negara_masters_id', $this->country->id)
            ->where('tahun', '=', $year)
            ->groupBy('bulan')
            ->get();

        $data = VariableData::where('tahun', '=', $year)
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->where('negara_masters_id', $this->country->id)
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
                return response()->json(['code' => 400, 'message' => 'Year data cannot be empty', 'data' => null], 200);
            }

            $bulan = VariableData::select('bulan')
                ->whereIn('variable_masters_id', [1, 2, 3, 4])
                ->where('tahun', '=', $request->year)
                ->where('negara_masters_id', $this->country->id)                
                ->groupBy('bulan')
                ->get();

            $data = VariableData::where('tahun', '=', $request->year)
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->where('negara_masters_id', $this->country->id)
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
            'year' => 'required|numeric|digits:4',
            'month' => 'required|numeric|digits_between:1,12',
            'npf' => 'required|numeric',
            'car' => 'required|numeric',
            'ipr' => 'required|numeric',
            'fdr' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid data', 'data' => $validator->errors()], 200);
        }

        $check = VariableData::where('negara_masters_id', 1)
        ->where('negara_masters_id', $this->country->id)
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->where('tahun', '=', $request->year)
            ->where('bulan', '=', $request->month)
            ->get();

        if ($check->count() > 0) {
            return response()->json(['code' => 500, 'message' => 'Data for year ' . $request->year . ' month ' . $request->month . ' already exists', 'data' => null], 200);
        }

        $insert = DB::transaction(function () use ($request) {
            $npf = new VariableData;
            $npf->negara_masters_id = $this->country->id;
            $npf->variable_masters_id = 1;
            $npf->tahun = $request->year;
            $npf->bulan = $request->month;
            $npf->value = $request->npf;
            $npf->save();

            $car = new VariableData;
            $car->negara_masters_id = $this->country->id;
            $car->variable_masters_id = 2;
            $car->tahun = $request->year;
            $car->bulan = $request->month;
            $car->value = $request->car;
            $car->save();

            $ipr = new VariableData;
            $ipr->negara_masters_id = $this->country->id;
            $ipr->variable_masters_id = 3;
            $ipr->tahun = $request->year;
            $ipr->bulan = $request->month;
            $ipr->value = $request->ipr;
            $ipr->save();

            $fdr = new VariableData;
            $fdr->negara_masters_id = $this->country->id;
            $fdr->variable_masters_id = 4;
            $fdr->tahun = $request->year;
            $fdr->bulan = $request->month;
            $fdr->value = $request->fdr;
            $fdr->save();

            return "Data saved successfully";
        });

        return response()->json(['code' => 200, 'message' => $insert, 'data' => null], 200);
    }

    public function edit()
    {
        // dd($bulan);
        $data = VariableData::where('tahun', '=', Route::current()->parameter('tahun'))
            ->where('bulan', '=', Route::current()->parameter('bulan'))
            ->where('negara_masters_id', $this->country->id)
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

        $update = DB::transaction(function () use ($request) {
            VariableData::where('tahun', request()->tahun)
            ->where('negara_masters_id', $this->country->id)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 1)
                ->update(['value' => $request->npf]);

            VariableData::where('tahun', request()->tahun)
            ->where('negara_masters_id', $this->country->id)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 2)
                ->update(['value' => $request->car]);

            VariableData::where('tahun', request()->tahun)
            ->where('negara_masters_id', $this->country->id)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 3)
                ->update(['value' => $request->ipr]);

            VariableData::where('tahun', request()->tahun)
            ->where('negara_masters_id', $this->country->id)
                ->where('bulan', request()->bulan)
                ->where('variable_masters_id', 4)
                ->update(['value' => $request->fdr]);

            return "Data updated successfully";
        });

        return response()->json(['code' => 200, 'message' => $update, 'data' => null], 200);
    }

    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tahun' => 'required|numeric|digits:4',
                'bulan' => 'required|numeric|digits_between:1,12'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 400, 'message' => 'Invalid Data' . $request->year, 'data' => $validator->errors()], 200);
            }

            VariableData::where('tahun', $request->tahun)
            ->where('negara_masters_id', $this->country->id)
                ->where('bulan', $request->bulan)
                ->delete();

            return response()->json(['code' => 200, 'message' => 'Data deleted successfully', 'data' => null], 200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }
}
