<?php

namespace App\Http\Controllers\Admin;

use App\Subscription;
use App\Http\Controllers\Controller;
use App\Package;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    protected $request;
    protected $subscription;
    public function __construct(Request $request, Subscription $subscription)
    {
        $this->request = $request;
        $this->subscription = $subscription;
    }

    public function index()
    {

        $subscriptions = $this->subscription->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $subscriptions = $subscriptions->where('name', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $subscriptions = $subscriptions->orderBy('id')->paginate(10);

            return view('admin.subscriptions.partial.partial', compact('subscriptions'));
        }
        $subscriptions = $subscriptions->orderBy('id')->paginate(10);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {

        $users = User::orderBy('id')->where('type', 'user')->get();
        $packages = Package::orderBy('id')->get();
        return view('admin.subscriptions.create', compact('users', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // dd(request()->all());

        $validator = Validator::make($this->request->all(), [
            'package_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }

            return redirect()->back()->withErrors($validator->errors());
        }

        $package = Package::findOrFail($this->request->package_id);

        $subscription = $this->subscription;
        $subscription->user_id = $this->request->user_id;
        $subscription->package_id = $this->request->package_id;
        $subscription->staff = $this->request->staff ? 1 : 0;
        $subscription->started_at = Carbon::now();
        $subscription->expired_at = Carbon::now()->addDays($package->duration);

        $subscription->save();

        if ($subscription) {
            return redirect('/all-subscriptions')->with('success', 'تم إضافة الباقة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $subscription = $this->subscription->find($id);

        return view('admin.subscriptions.single_subscription', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $users = User::orderBy('id')->where('type', 'user')->get();
        $packages = Package::orderBy('id')->get();
        $subscription = subscription::findOrFail($id);
        if ($subscription->type == 'admin') {
            abort(403);
        }
        return view('admin.subscriptions.edit', compact('subscription', 'users', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        // dd(request()->all());

        $validator = Validator::make($this->request->all(), [
            'package_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }

            return redirect()->back()->withErrors($validator->errors());
        }


        $subscription = $this->subscription->find($this->request->subscription_id);



        $package = Package::findOrFail($this->request->package_id);

        $subscription->user_id = $this->request->user_id;
        $subscription->package_id = $this->request->package_id;
        $subscription->staff = isset($this->request->staff) ? 1 : 0;
        $subscription->started_at = Carbon::now();
        $subscription->expired_at = Carbon::now()->addDays($package->duration);
        $subscription->save();
        if ($subscription) {
            return redirect('/all-subscriptions')->with('success', 'تم تعديل الباقة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $subscription = Subscription::findOrFail($id);
        if ($subscription->type == 'admin') {
            abort(403);
        }
        if ($subscription->delete()) {
            return redirect()->back()->with('success', 'تم حذف الباقة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }



    public function changesubscriptionStatus($id)
    {

        $subscription = subscription::findOrFail($id);

        if ($subscription->status == 0) {
            $subscription->status = 1;
        } else {
            $subscription->status = 0;
        }
        $subscription->save();
        return redirect('/all-subscriptions')->with('success', 'تم تعديل الباقة بنجاح');
    }
}
