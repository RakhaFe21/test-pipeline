<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class BankBasedYearController extends Controller
{

    private $country;

    public function __construct()
    {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }
    
    public function index(Request $request)
    {

        $weight = VariableWeight::where('negara_masters_id', $this->country->id)->whereNotIn('variable_masters_id', [6,7,8,9])->get();

        return view('dashboard.bank.ibri.basedyear.index', compact( 'weight'));
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

        $update = DB::transaction(function () use ($request, $select) {
            try {
                $message = '';

                if ($select->count() > 0) {
                    VariableWeight::where('negara_masters_id', 1)
                        ->where('variable_masters_id', 1)
                        ->update(['based_year' => $request->npf]);

                    VariableWeight::where('negara_masters_id', 1)
                        ->where('variable_masters_id', 2)
                        ->update(['based_year' => $request->car]);

                    VariableWeight::where('negara_masters_id', 1)
                        ->where('variable_masters_id', 3)
                        ->update(['based_year' => $request->ipr]);

                    VariableWeight::where('negara_masters_id', 1)
                        ->where('variable_masters_id', 4)
                        ->update(['based_year' => $request->fdr]);

                    $message = 'Data update successfully';
                } else {
                    VariableWeight::insert(['negara_masters_id' => 1, 'variable_masters_id' => 1, 'based_year' => $request->npf, 'created_at' => Carbon::now()]);
                    VariableWeight::insert(['negara_masters_id' => 1, 'variable_masters_id' => 2, 'based_year' => $request->car, 'created_at' => Carbon::now()]);
                    VariableWeight::insert(['negara_masters_id' => 1, 'variable_masters_id' => 3, 'based_year' => $request->ipr, 'created_at' => Carbon::now()]);
                    VariableWeight::insert(['negara_masters_id' => 1, 'variable_masters_id' => 4, 'based_year' => $request->fdr, 'created_at' => Carbon::now()]);

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
