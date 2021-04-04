<?php

namespace App\Http\Controllers\Admin;

use App\CountryAdmin;
use App\Http\Controllers\Controller;
use App\SiteSetting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Helper;

class AuthController extends Controller
{
    // login function
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
            'type' => 'admin'
        ];
        if (auth()->attempt($credentials)) {
            return redirect('/dashboard');
        } else {
            return redirect('/');
        }
    }

    public function admin_login()
    {
        return view('auth.login');
    }

    // logout function

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
