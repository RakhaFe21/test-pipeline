<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NegaraMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class NegaraController extends Controller
{
    public function index()
    {
        $countries = NegaraMaster::all();
        return view('dashboard.negara.index', [
            'countries' => $countries
        ]);
    }

    public function create()
    {
        return view('dashboard.negara.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid data', 'data' => $validator->errors()], 200);
        }

        $insert = DB::transaction(function () use ($request) {
            NegaraMaster::create([
                'nama_negara' => $request->name,
                'code'        => $request->code
            ]);

            return "Data saved successfully";
        });

        return response()->json(['code' => 200, 'message' => $insert, 'data' => null], 200);
    }

    public function edit(Request $request)
    {

        $data = NegaraMaster::where('code', Route::current()->parameter('code'))->first();

        return view('dashboard.negara.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Validate', 'data' => $validator->errors()], 200);
        }

        $update = DB::transaction(function () use ($request) {
            NegaraMaster::where('id', $request->id)->update([
                'nama_negara' => $request->name,
                'code'        => $request->code
            ]);


            return "Data updated successfully";
        });

        return response()->json(['code' => 200, 'message' => $update, 'data' => null], 200);
    }

    public function delete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 400, 'message' => 'Invalid Data', 'data' => $validator->errors()], 200);
            }

            NegaraMaster::find($request->id)->delete();

            return response()->json(['code' => 200, 'message' => 'Data deleted successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }
}
