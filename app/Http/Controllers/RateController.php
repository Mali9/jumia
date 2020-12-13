<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class RateController extends Controller
{

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'rating'=> 'required',
            'rated_user_id'=> 'required'
        ]);
     
        if($validator->fails()){
            return $validator->errors();
        }

        $rate['rating'] = $request['rating'];
        $rate['comment'] = $request['comment'];
        $rate['rater_id'] = auth()->guard('api')->id();
        $rate['rated_user_id'] = $request['rated_user_id'];
        $rate['created_at'] = Carbon::now();
        DB::table('rates')->insert($rate);

        $latest_rate = DB::table('rates')->where('rater_id',auth()->guard('api')->id())->latest()->first();
        notifyUserOfRate($request['rated_user_id'],$latest_rate->id);
        return response()->json(['data'=>'Rated successfully'],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRate(Request $request, $id)
    {
        $rate = DB::table('rates')->find($id);

        $validator = Validator::make($request->all(),[
            'rating'=> 'required',
            'rated_user_id'=> 'required'
        ]);
     
        if($validator->fails()){
            return $validator->errors();
        }

            $rate['rating'] = $request['rating'];
            $rate['comment'] = $request['comment'];
            $rate['rater_id'] = auth()->guard('api')->id();
            $rate['rated_user_id'] = $request['rated_user_id'];
            $rate['updated_at'] = Carbon::now();
            DB::table('rates')->where('id',$id)->update($rate);
            return response()->json(['data'=>'Rated successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRate($id)
    {
        $rate = DB::table('rates')->where('id', $id)->first();

        if($rate['rater_id'] !== auth()->guard('api')->id()){
            return response()->json(['data'=> 'unauthorized'], 401);
        }
        DB::table('rates')->where('id',$id)->delete();
        return response()->json(['data'=>'Deleted rate successfully'],200);
    }

}
