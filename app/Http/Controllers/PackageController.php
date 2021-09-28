<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Package;
use App\Services\PayPalService;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Storage;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PackageController extends Controller
{

    private $_api_context;

    protected $request;
    protected $user;
    protected $paypal;
    public function __construct(Request $request, User $user, PayPalService $paypal)
    {

        $this->request = $request;
        $this->user = $user;
        $this->paypal = $paypal;
        $paypal_configuration = \Config::get('paypal');
        // dd($paypal_configuration);
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }


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
        // dd();
        $url = "https://secure.paytabs.sa/payment/request";
        $data = [
            "profile_id" => 68353,
            "tran_type" => "sale",
            "tran_class" => "ecom",
            "cart_id" => "4244b9fd-c7e9-4f16-8d3c-4fe7bf6c48ca",
            "cart_description" => $package->name,
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
            $subscribe->expired_at = Carbon::now('Asia/Riyadh')->addDays($package->duration * 30);
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
        return response()->json(['data' => $subscribtions], 200)->withCookie(cookie('auth_user', 'ok', 1));
    }


    // pay with paypal
    public function userSubscription()
    {
        $package_id = request('package_id');
        $user_id = auth()->user()->id;
        // return $user_id;

        $package = Package::findOrFail($package_id);


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();


        $item_1->setName($package->name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($package->price);


        $item_list = new ItemList();
        $item_list->setItems(array($item_1));


        $supscripe_amount = $package->price;
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($supscripe_amount);



        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('سيتم خصم قيمة الاشتراك ');


        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('api/supscripe', [$user_id, $package_id]))
            ->setCancelUrl(url('api/supscripe', [$user_id, $package_id]));


        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
            // dd( $payment->toArray());

        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                return false;
            } else {
                return false;
            }
        }
        // Session::put('paypal_payment_id', $payment->getId());


        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }
        return false;
    }



    public function supscripe($user_id, $package_id, Request $request)
    {
        $payment_id = request('paymentId');
        // dd($payment_id);

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            return response()->json([
                'errors' => 'error in payments'
            ], 400);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $package = Package::findOrFail($package_id);
            $subscribe = new Subscription;
            $subscribe->user_id = $user_id;
            $subscribe->package_id = $package_id;
            $subscribe->started_at = Carbon::now('Asia/Riyadh');
            $subscribe->expired_at = Carbon::now('Asia/Riyadh')->addDays($package->duration * 30);
            $subscribe->save();
            return view('success');
        } else {
            return view('fail');
        }
    }
}
