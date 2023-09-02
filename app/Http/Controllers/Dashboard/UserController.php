<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('dashboard.user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('dashboard.user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'username'  => 'required|string',
            'email'     => 'required|email',
            'password'  => 'required|string',
            'role'      => 'required|int',
            'address'   => 'required|string',
            'image'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid data', 'data' => $validator->errors()], 200);
        }

        if ($request->image) {
            Storage::disk('public')->put('profile', $request->file('image'));
        }

        $insert = DB::transaction(function () use ($request) {
            User::create([
                'name'              => $request->name,
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => bcrypt($request->password),
                'role'              => $request->role,
                'address'           => $request->address,
                'profile_picture'   => $request->file('image')->hashName()
            ]);

            return "Data saved successfully";
        });

        return response()->json(['code' => 200, 'message' => $insert, 'data' => null], 200);
    }

    public function edit($code, $id)
    {
        $user = User::where('id', Route::current()->parameter('id'))->first();
        return view('dashboard.user.edit',[
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required',
            'name'      => 'required|string',
            'username'  => 'required|string',
            'email'     => 'required|email',
            'role'      => 'required|int',
            'address' => 'required|string',
            'image'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid data', 'data' => $validator->errors()], 200);
        }

        $filename = null;
        if ($request->image) {
            Storage::disk('public')->put('profile', $request->file('image'));
            $filename = $request->file('image')->hashName();
        }

        $insert = DB::transaction(function () use ($request, $filename) {
            $user = User::where('id', $request->id)->first();
            $user->update([
                'name'              => $request->name,
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => @$request->password ? bcrypt($request->password) : $user->getOriginal('password'),
                'role'              => $request->role,
                'address'           => $request->address,
                'profile_picture'   => @$filename ? $filename :  $user->getOriginal('profile_picture')
            ]);

            return "Data saved successfully";
        });

        return response()->json(['code' => 200, 'message' => $insert, 'data' => null], 200);
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

            User::find($request->id)->delete();

            return response()->json(['code' => 200, 'message' => 'Data deleted successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }
}
