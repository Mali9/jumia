<?php

namespace App\Http\Controllers\Admin;

use App\Condition;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('conditions')) {
            return view('forbidden_page');
        }
        $conditions = Condition::first();
        return view('admin.conditions.index', compact('conditions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('conditions')) {
            return view('forbidden_page');
        }
        $conditions = Condition::first();
        if ($conditions) {
            $conditions->terms_conditions = $request->terms_conditions;
            $conditions->save();
            return view('admin.conditions.index', compact('conditions'));
        }
        $conditions = new Condition();

        $conditions->terms_conditions = $request->terms_conditions;
        $conditions->save();
        return view('admin.conditions.index', compact('conditions'));
    }
}
