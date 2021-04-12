<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notification;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::paginate(10);
        return view('notifications', compact('notifications'));
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }


    public function sendNotification(Request $request)
    {

        $SERVER_API_KEY = 'AAAAZLOa8iw:APA91bGYRFmFXXAp4fYtTj3Nbw0_ypiHdVeude3IPmMNh5b0XtpHFluwUISCaBnChJ5b18A16UJ8sYJVeiVpj7rnnyNZK68QHFaDRUSby9RcHcZLoqM-5Mjn44PYUzAb5vnPJHXkRndf';

        $data = [
            "to" => '/topics/all',
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        Notification::create(['title' => $request->title, 'body' => $request->body]);
        return redirect()->back()->with('success', 'success');
    }
}
