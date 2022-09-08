<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    use PasswordValidationRules;

    public function login(Request $request)
    {
        if (Auth::user()) {
            return response()
                ->json(['code' => 500, 'message' => 'Anda sudah masuk.', 'data' => null], 200);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['code' => 400, 'message' => 'Validate', 'data' => $validator->errors()], 200);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()
                ->json(['code' => 500, 'message' => 'Periksa kembali email dan password anda.', 'data' => null], 200);
        }

        return response()
            ->json(['code' => 200, 'message' => 'Berhasil masuk', 'data' => null], 200);
    }

    public function register(Request $request)
    {
        if (Auth::user()) {
            return response()
                ->json(['code' => 500, 'message' => 'Anda sudah terdaftar.', 'data' => null], 200);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique(User::class),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['code' => 400, 'message' => 'Validate', 'data' => $validator->errors()], 200);
        }

        $create = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        if (!$create) {
            return response()
                ->json(['code' => 500, 'message' => 'Gagal menyimpan data', 'data' => null], 200);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()
                ->json(['code' => 500, 'message' => 'Gagal masuk', 'data' => null], 200);
        }

        return response()
            ->json(['code' => 200, 'message' => 'Pendaftaran Berhasil', 'data' => null], 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email'
            ],
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['code' => 400, 'message' => 'Validate', 'data' => $validator->errors()], 200);
        }

        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return env('APP_URL') . "/auth/change-password/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['code' => 200, 'message' => __($status), 'data' => null], 200)
            : response()->json(['code' => 500, 'message' => __($status), 'data' => ['email' => __($status)]], 200);
    }

    public function changePassword()
    {
        return view('landing.home');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => [
                'required',
                'email'
            ],
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['code' => 400, 'message' => 'Validate', 'data' => $validator->errors()], 200);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['code' => 200, 'message' => __($status), 'data' => null], 200)
            : response()->json(['code' => 500, 'message' => __($status), 'data' => ['email' => __($status)]], 200);
    }
}
