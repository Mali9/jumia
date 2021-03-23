<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RestPasswordMail;
use App\Mail\RestUserNameMail;
use App\RestPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\PasswordHash;

class ResetController extends Controller
{
    use PasswordHash;

    protected $user;



    // forget_password

    public function forgetPassword()
    {
        if (request('email')) {
            $user = User::where('user_email', request('email'))->first();
        } else {
            $user = User::where('user_login', request('username'))->first();
        }
        if ($user) {
            $otp = rand(1, 99999);
            Mail::to($user->user_email)
                ->send(new RestPasswordMail("Please Use this Code To Rest Your Password : " . $otp));


            $rest = RestPassword::where('user_id', $user->id)->first();
            if ($rest) {
                $rest->otp = $otp;
                $rest->save();
            } else {
                $new_rest = new RestPassword();
                $new_rest->otp = $otp;
                $new_rest->user_id = $user->id;
                $new_rest->save();
            }

            return  response()->json(['message' => 'تم إرسال كلمة المرور المؤقتة الى البريد الإلكتروني الخاص بك'], 200);
        } else {
            return response()->json(['errors' => 'خطأ في البريد الإلكتروني'], 400);
        }
    }

    // change password

    public function ChangePassword(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'otp' => 'required',
            'password' => 'required|confirmed|min:6|max:100',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors['errors'][$index]['key'] = $key;
                $errors['errors'][$index]['error'] = $error[0];
                $index++;
            }

            return response()->json(['errors' => $errors], 400);
        }

        $otp = RestPassword::where('otp', request('otp'))->first();
        if ($otp) {
            $user = User::where('ID', $otp->user_id)->first();
            // return $request['password'];
            // return $this->HashPassword($request['password']);
            $user->user_pass = $this->HashPassword($request['password']);
            $user->save();
            $otp->delete();
            return  response()->json(['message' => 'تم تغيير كلمة المرور بنجاح'], 200);
        } else {
            return response()->json(['errors' => 'كلمة مرور مؤقتة خاطئة'], 400);
        }
    }
}
