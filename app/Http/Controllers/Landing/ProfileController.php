<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('landing.profile');
    }

    public function update(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['string', 'max:255', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id . ',id',],
            'password' => ['string', 'min:8', 'max:255', 'nullable']
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['code' => 400, 'message' => 'Validate', 'data' => $validator->errors()], 200);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request['name'];
        $user->address = $request['address'];
        $user->email = $request['email'];

        if ($request['password']) {
            $user->password = Hash::make($request['password']);
        }

        if ($request['email_notification']) {
            $user->email_notification = 1;
        } else {
            $user->email_notification = 0;
        }

        if (!$user->save()) {
            return response()
                ->json(['code' => 400, 'message' => 'Update data gagal', 'data' => null], 200);
        }

        return response()
            ->json(['code' => 200, 'message' => 'Update data berhasil', 'data' => $request->all], 200);
    }

    public function upload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['code' => 400, 'message' => 'File foto tidak valid', 'data' => null], 200);
        }

        if (!$request->file('file')) {
            return response()
                ->json(['code' => 400, 'message' => 'File foto kosong', 'data' => null], 200);
        }

        $file = $request->file('file');

        if (!$file->storeAs('public/profile', Auth::user()->username . '.png')) {
            return response()
                ->json(['code' => 400, 'message' => 'Upload foto gagal', 'data' => null], 200);
        }

        $user = User::find(Auth::user()->id);
        $user->profile_picture = Auth::user()->username . '.png';

        if (!$user->save()) {
            return response()
                ->json(['code' => 400, 'message' => 'Update foto gagal', 'data' => null], 200);
        }

        return response()
            ->json(['code' => 200, 'message' => 'Foto berhasil di perbaharui', 'data' => null], 200);
    }

    public function delete(Request $request)
    {

        $user = User::find(Auth::user()->id);

        if (!$user->delete()) {
            return response()
                ->json(['code' => 400, 'message' => 'Hapus akun gagal', 'data' => null], 200);
        }

        return response()
            ->json(['code' => 200, 'message' => 'Hapus akun berhasil', 'data' => $request->all], 200);
    }
}
