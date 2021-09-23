<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    protected $request;
    protected $user;

    public function __construct(Request $request, User $user)
    {

        $this->request = $request;
        $this->user = $user;
    }



    // login function
    public function login()
    {
        $credentials = [
            'username' => $this->request->username,
            'password' => $this->request->password,
            'status' => 1
        ];
        $errors = [];

        if (Auth::attempt($credentials)) {

            $token = Auth::user()->createToken('authToken')->accessToken;
            return response()->json([
                'token' => $token,
                'data' => Auth::user(),
                'code' => 200
            ], 200);
        } else {

            if ($this->user->where('username', $this->request->username)->first()) {
                if ($this->user->where('username', $this->request->username)->where('status', 0)->first()) {
                    $errors[] = "المستخدم غير مفعل";
                } else {
                    $errors[] = "كلمة المرور غير صحيحة";
                }
            } else {
                $errors[] = "أسم المستخدم غير صحيح";
            }
            return response()->json([
                'errors' => $errors,
                'code' => 400
            ], 400);
        }
    }

    public function register()
    {
        // dd(request()->all());
        $messages =  [
            'fullname.required' => 'يجب إدخال أسم المستخدم',
            'username.required' => 'يجب إدخال أسم المستخدم',
            'username.unique' => ' أسم المستخدم موجود بالفعل',
            'email.required' => 'يجب إدخال البريد الإلكتروني  للمستخدم',
            'email.unique' => '  البريد الإلكتروني  للمستخدم موجود بالفعل',
            'email.email' => '  من فضلك أدخل بريد الكتروني صحيح',
            'password.required' => 'يجب إدخال كلمة المرور',
            'password.min' => 'يجب ألا تقل  كلمة المرور عن 6 أرقام أوأحرف',
            'password.confirmed' => 'كلمة المرور غير متطابقة',

        ];
        $validator = Validator::make(request()->all(), [
            'fullname' => 'required|max:100',
            'username' => 'required|unique:users,username',
            'email' => 'required|max:100|email|unique:users,email',
            'password' => 'required|min:6|max:100|confirmed',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ], $messages);


        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }
            return response()->json(['errors' => $errors], 400);
        }

        $this->user->username = $this->request->username;
        $this->user->fullname = $this->request->fullname;
        $this->user->email = $this->request->email;
        $this->user->password = bcrypt($this->request->password);

        if (isset(request()->image) && !empty(request()->image)) {
            $image_path = 'uploads/users/' . $this->user->image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = Helper::upload_user_image(request()->image);
            $this->user->image = $imageName;
        }
        $this->user->save();

        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
        ];

        // auth()->attempt($credentials);
        // $user = Auth::user();
        // $token = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'تم إنشاء المتسخدم بنجاح',
            'data' => $this->user,
            // 'token' => $token
        ], 200);
        // return response()->json(['message' => 'تم إنشاء المتسخدم بنجاح', 'data' => $this->user], 200);
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
