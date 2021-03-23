<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myProfile()
    {
        // $user = User::findOrFail(request('id'));
        return response()->json(['data' => auth()->user()], 200);
    }

    public function reportUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'reported_user_id' => 'required',
            'report_reason' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }


        $report['reporter_id'] = auth()->guard('api')->id();
        $report['reported_user_id'] = $request['reported_user_id'];
        $report['report_reason'] = $request['report_reason'];
        $report['created_at'] = Carbon::now();

        DB::table('reportedusers')->insert($report);

        return response()->json(['data' => 'Your report was submitted to Moderators and will be reviewed carfully'], 200);
    }
}
