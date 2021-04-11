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

    public function Subscribe()
    {
        $user_id = auth()->user()->id;
        $package_id = request('package_id');

        $package = Package::findOrFail($package_id);

        $subscribe = new Subscription;
        $subscribe->user_id = $user_id;
        $subscribe->package_id = $package_id;
        $subscribe->started_at = Carbon::now();
        $subscribe->expired_at = Carbon::now()->addDays($package->duration);
        $subscribe->save();
        return response()->json(['data' => 'تم الإشتراك بنجاح'], 200);
    }

    public function mySubscribtions()
    {
        $subscribtions = Subscription::where('user_id', auth()->user()->id)->with('user', 'package')->get();
        return response()->json(['data' => $subscribtions], 200);
    }
}
