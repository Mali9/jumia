<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required|numeric',
        ]);
     
        if($validator->fails()){
            return $validator->errors();
        }


        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        $user['password'] = Hash::make($request['password']);
        $user['phone'] = $request['phone'];
        $imagePath = saveImage($request['image']);
        $user['image'] = $imagePath;
        User::create($user);
        $user = User::where('email', $request->email)->first();
        event(new Registered($user));
        return response()->json(['data' => 'Please check your email and click on the link we sent you'], 200);
    }

    public function login(Request $request)
    {
            $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();

        if (!$user) {
            return response(['message' => 'there is no user with that email'], 401);
        } else {
            if (!Auth::attempt($request->except('token'))) {

                return response(['message' => 'Wrong username or password'], 401);
            }

            $accessToken = Auth::user()->createToken('authToken')->accessToken;
            return response(['user' => Auth::user(), 'access_token' => $accessToken]);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['success' => 'You have logged out successfully'], 200);
        } else {
            return response()->json(['error' => 'We apologize, something went wrong.'], 500);
        }
    }

    public function verifyEmail(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->email_verified_at = Carbon::now();
        $user->save();
        return response() ->json(['data' => 'email verified'], 200);
    }
}
