<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Package;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return response()->json(['data' => $packages], 200);
    }

    public function payment()
    {

        $user_id = auth()->user()->id;
        $package_id = request('package_id');

        $package = Package::findOrFail($package_id);
        $url = "https://test.oppwa.com/v1/payments";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" . $package->price .
            "&currency=EUR" .
            "&paymentBrand=" . request('paymentBrand') .
            "&paymentType=DB" .
            "&card.number=" . request('number') .
            "&card.holder=" . request('name') .
            "&card.expiryMonth=" . request('expiryMonth') .
            "&card.expiryYear=" . request('expiryYear') .
            "&card.cvv=" . request('cvv');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData1 = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData1);

        // dd($res);
        $url = "https://test.oppwa.com/v1/payments/" . $res->id;
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($responseData);
        $code = $result->result->code;
        // dd($result->result);
        // return $code;
        if ($code != '000.100.110') {
            return response()->json(['data' => 'هناك خطأ في عملية الدفع'], 400);
        }



        $subscribe = new Subscription;
        $subscribe->user_id = $user_id;
        $subscribe->package_id = $package_id;
        $subscribe->started_at = Carbon::now('Asia/Riyadh');
        $subscribe->expired_at = Carbon::now('Asia/Riyadh')->addDays($package->duration);
        $subscribe->save();
        return response()->json(['data' => 'تم الإشتراك بنجاح'], 200);
    }

    public function mySubscribtions()
    {
        $subscribtions = Subscription::where('user_id', auth()->user()->id)->with('user', 'package')->get();
        return response()->json(['data' => $subscribtions], 200);
    }




    public function paymentWithFront()
    {

        $user_id = auth()->user()->id;
        $package_id = request('package_id');

        $package = Package::findOrFail($package_id);

        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" . $package->price .
            "&currency=EUR" .
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData);
        return view('welcome', compact('res'));
    }
}
