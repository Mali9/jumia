<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;

use App\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-site-settings')) {
            return view('forbidden_page');
        }

        $settings = SiteSetting::first();
        return view('settings', compact('settings'));
    }


    public function update(Request $request)
    {



        if ($request->browsing_duration && !empty($request->browsing_duration)) {

            DB::update('update site_settings set browsing_duration = ?', [$request->browsing_duration]);
        }


        if ($request->bob_up_text && !empty($request->bob_up_text)) {

            DB::update('update site_settings set bob_up_text = ?', [$request->bob_up_text]);
        }


        return redirect()->back()->with('success', 'تم التعديل بنجاح');
        // return response()->json(['message' => 'success', 'data' => $SiteSetting], 200);
    }
}
