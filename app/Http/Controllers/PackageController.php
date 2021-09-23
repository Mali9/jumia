<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Package;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return response()->json(['data' => $packages], 200);
    }

    public function payment()
    {

        $package_id = request('package_id');
        $user_id = auth()->user()->id;
        // return $user_id;

        $package = Package::findOrFail($package_id);
        $url = "https://secure.paytabs.sa/payment/request";
        $data = [
            "profile_id" => 68353,
            "tran_type" => "sale",
            "tran_class" => "ecom",
            "cart_id" => "4244b9fd-c7e9-4f16-8d3c-4fe7bf6c48ca",
            "cart_description" => $package->fullname,
            "cart_currency" => "SAR",
            "cart_amount" => $package->price,
            "return" => url('api/get_result/' . $package_id . '/' . $user_id),

            "customer_details" => array(
                "name" => auth()->user()->username,
                "email" => auth()->user()->email,
                "phone" => "",
                "street1" => "",
                "city" => "",
                "state" => "",
                "country" => ""
            ),
        ];



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authorization:SLJNRNR9WT-JB9NNRHRTL-RKTRRKZHNN',
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $res = json_decode($responseData);
        // dd($res);
        if (isset($res->redirect_url)) {
            return redirect($res->redirect_url);
        } else {
            return response()->json('errors in payments', 400);
        }
    }

    public function getPaymentResult($package_id, $user_id)
    {

        $code = request('respStatus');

        if ($code == 'A') {
            $package = Package::findOrFail($package_id);
            $subscribe = new Subscription;
            $subscribe->user_id = $user_id;
            $subscribe->package_id = $package_id;
            $subscribe->started_at = Carbon::now('Asia/Riyadh');
            $subscribe->expired_at = Carbon::now('Asia/Riyadh')->addDays($package->duration);
            $subscribe->save();
            return view('success');
        } else {
            return view('fail');
        }
    }

    public function callback()
    {
        Storage::put('file.txt', 'Your name');
        dd($request->all());

        // return response()->json(['data' => 'هناك خطأ في عملية الدفع'], 400);
    }

    public function mySubscribtions()
    {
        $subscribtions = Subscription::where('user_id', auth()->user()->id)->with('user', 'package')->get();
        return response()->json(['data' => $subscribtions], 200);
    }
}
