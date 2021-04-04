<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Helper;

class UserMailController extends Controller
{
    public function mailForm()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-emails')) {
            return view('forbidden_page');
        }

        $users = User::all();
        return view('mails.mail_form', compact('users'));
    }

    public function smsForm()
    {
        $users = User::all();
        return view('mails.sms_form', compact('users'));
    }
    public function sendMail()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-emails')) {
            return view('forbidden_page');
        }
        // dd(request()->all());

        $emails = request()->emails;
        $message = request()->message;

        foreach ($emails  as $email) {

            Mail::to($email)
                ->send(new UserMail($message));
        }

        return redirect()->back()->with('success', 'تم إرسال البريد الإلكتروني بنجاح');
    }

    public function sendSMS()
    {
        dd(request()->all());
    }
}
