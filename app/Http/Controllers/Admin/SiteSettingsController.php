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
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-site-settings')) {
            return view('forbidden_page');
        }



        if ($request->answer_duration && !empty($request->answer_duration)) {
            if (!is_numeric($request->answer_duration)) {
                return response()->json(['message' => 'يجب ادخال ارقام فقط'], 400);
            }
            DB::update('update site_settings set answer_duration = ?', [$request->answer_duration]);
        }

        if ($request->competition_duration && !empty($request->competition_duration)) {
            if (!is_numeric($request->competition_duration)) {
                return response()->json(['message' => 'يجب ادخال ارقام فقط'], 400);
            }
            DB::update('update site_settings set competition_duration = ?', [$request->competition_duration]);
        }

        if ($request->registration_value && !empty($request->registration_value)) {
            if (!is_numeric($request->registration_value)) {
                return response()->json(['message' => 'يجب ادخال ارقام فقط'], 400);
            }
            DB::update('update site_settings set registration_value = ?', [$request->registration_value]);
        }
        if ($request->activation_value && !empty($request->activation_value)) {
            if (!is_numeric($request->activation_value)) {
                return response()->json(['message' => 'يجب ادخال ارقام فقط'], 400);
            }
            DB::update('update site_settings set activation_value = ?', [$request->activation_value]);
        }

        if ($request->site_title && !empty($request->site_title)) {
            DB::update('update site_settings set site_title = ?', [$request->site_title]);
        }
        $SiteSetting = SiteSetting::first();

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
        // return response()->json(['message' => 'success', 'data' => $SiteSetting], 200);
    }
}
