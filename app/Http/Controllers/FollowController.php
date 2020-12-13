<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FollowController extends Controller
{
    
    public function allFollowers($id)
    {
        if($id != auth()->guard('api')->id()){
            return response()->json(['data' => 'Unauthorized'],401);
        }

        $follows = DB::table('follows')->where('followed_user_id',$id)->get();
        if(!$follows){
            return response()->json(['data' => 'You do not have any followers yet'],200);
        }

        $followers = [];
        foreach($follows as $follow){
            $followers [] = User::where('id', $follow->follower_id)->get();
        }
        return response()->json(['data' => $followers],200);
    }


    public function allFollowed(Request $request)
    {
        if($request->id != auth()->guard('api')->id()){
            return response()->json(['data' => 'Unauthorized'],401);
        }

        switch($request->type){
            case "people":
                $followed = DB::table('follows')->where('follower_id',$request->id)->where('followed_category_id',null)->get();
                if(!$followed){
                    return response()->json(['data' => 'You are not following anyone yet'],200);
                }
                
                $followed_ppl = [];
                foreach($followed as $follow){
                    $followed_ppl [] = User::where('id', $follow->followed_user_id)->get();
                }
                return response()->json(['data' => $followed_ppl],200);

                case "categories":
                    $followed = DB::table('follows')->where('follower_id',$request->id)->where('followed_user_id',null)->get();
                    if(!$followed){
                        return response()->json(['data' => 'You are not following any categories yet'],200);
                    }
                    
                    $followed_categories = [];
                    foreach($followed as $follow){
                        $followed_categories [] = Category::where('id', $follow->target_id)->get();
                    }
                    return response()->json(['data' => $followed_categories],200);
        }

        
    }


    public function follow(Request $request){

        switch($request->type){
            case "people":
                $follow['followed_user_id'] = $request->id;
                $follow['follower_id'] = auth()->guard('api')->id();
                $follow['followed_category_id'] = null;
                $follow['created_at'] = Carbon::now();
                DB::table('follows')->insert($follow);
                notifyUserOfFollower($request->id, auth()->guard('api')->id());
                return response()->json(['data' => 'Success'],200);

                case "categories":
                    $follow['followed_category_id'] = $request->id;
                    $follow['follower_id'] = auth()->guard('api')->id();
                    $follow['followed_user_id'] = null;
                    $follow['created_at'] = Carbon::now();
                    DB::table('follows')->insert($follow);
                    return response()->json(['data' => 'Success'],200);
        }        
        
    }

    public function unfollow(Request $request){

        switch($request->type){
            case "people":
                DB::table('follows')->where('followed_user_id', $request->id)->where('follower_id',  auth()->guard('api')->id)
                ->delete();
                return response()->json(['data' => 'Success'],200);

                case "categories":
                DB::table('follows')->where('followed_category_id', $request->id)->where('follower_id',  auth()->guard('api')->id)
                ->delete();
                return response()->json(['data' => 'Success'],200);
        }   

    }
}
