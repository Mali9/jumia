<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\PasswordHash;

class LoginController extends Controller
{
    use PasswordHash;
    public function register(Request $request)
    {

        $messages =  [
            'user_login.required' => 'يجب  أدخال أسم المتسخدم ',
            'user_login.unique' => ' أسم المتسخدم موجود من قبل ',
            'user_email.required' => 'يجب أدخال البريد الإلكتروني ',
            'user_email.unique' => ' البريدالإلكتروني موجود من قبل ',

            'user_pass.required' => 'يجب  أدخال كلمة المرور ',
            'user_pass.confirmed' => 'يجب  أن تكون كلمة المرور متطابقة ',
        ];
        $validator = Validator::make($request->all(), [
            'user_login' => 'required|max:255|unique:wp_users,user_login',
            'user_email' => 'required|email|unique:wp_users,user_email',
            'password' => 'required|confirmed',
        ], $messages);



        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors['errors'][$index]['key'] = $key;
                $errors['errors'][$index]['error'] = $error[0];
                $index++;
            }

            return response()->json(['data' => $errors], 400);
        }

        $user = new User;
        $user->user_login = $request['user_login'];
        $user->user_email = $request['user_email'];
        $user->user_pass = $this->HashPassword($request['password']);
        $user->user_registered = Carbon::now();
        $user->save();
        $accessToken = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response(['msg' => 'تم التسجيل بنجاح', 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_login' => 'required',
            'user_pass' => 'required'
        ]);

        $user = User::where('user_login', $request->user_login)->first();

        // return $request->except('token');

        if (!$user) {
            return response(['message' => 'لا يوجد مستخدم بهذا الاسم'], 401);
        } else {
            // $password_hashed = $this->HashPassword(trim($request->password));
            if ($this->CheckPassword($request->user_pass, $user->user_pass)) {
                $accessToken = $user->createToken('Laravel Password Grant Client')->accessToken;

                // $accessToken = Auth::user()->createToken('authToken')->accessToken;
                return response(['user' => $user, 'access_token' => $accessToken]);
            } else {
                return response(['message' => 'كلمة مرور خاطئة'], 401);
            }
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
            return response()->json(['success' => 'تم تسجيل الخروج بنجاح'], 200);
        } else {
            return response()->json(['error' => 'We apologize, something went wrong.'], 500);
        }
    }
}
