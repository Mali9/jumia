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

        $package_id = request('package_id');

        $package = Package::findOrFail($package_id);
        $url = "https://secure.paytabs.sa/payment/request";
        $data = [
            "profile_id" => 66105,
            "tran_type" => "sale",
            "tran_class" => "ecom",
            "cart_id" => "4244b9fd-c7e9-4f16-8d3c-4fe7bf6c48ca",
            "cart_description" => "Dummy data",
            "cart_currency" => "SAR",
            "cart_amount" => $package->price,
            "callback" => url('/callback'),
            "return" => url('api/success/' . $package_id),

            "customer_details" => array(
                "name" => "mohamed",
                "email" => "mohamedalidimofinf@gmail.com",
                "phone" => "+966 50 505 0550",
                "street1" => "Your Address",
                "city" => "Riyad",
                "state" => "01",
                "country" => "SA"
            ),
        ];



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authorization:SLJNRG299K-JBKWTLRTHD-RZHGRGZHDB',
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
        return redirect($res->redirect_url);
    }

    public function success($package_id)
    {

        $user_id = auth()->user()->id;
        $subscribe = new Subscription;
        $subscribe->user_id = $user_id;
        $subscribe->package_id = $package_id;
        $subscribe->started_at = Carbon::now('Asia/Riyadh');
        $subscribe->expired_at = Carbon::now('Asia/Riyadh')->addDays($package->duration);
        $subscribe->save();
        return response()->json(['data' => 'تم الإشتراك بنجاح'], 200);
    }

    public function callback()
    {


        return response()->json(['data' => 'هناك خطأ في عملية الدفع'], 400);
    }

    public function mySubscribtions()
    {
        $subscribtions = Subscription::where('user_id', auth()->user()->id)->with('user', 'package')->get();
        return response()->json(['data' => $subscribtions], 200);
    }
}
