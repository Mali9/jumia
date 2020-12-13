<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\User;
use App\Notifications\NewFollower;

if(!function_exists('saveImage')){

 function saveImage($image){
    $imageKey = Str::random(10);
    $imageName = $imageKey . '.' .  $image->getClientOriginalExtension();
    $image->move(public_path('uploads/products/'), $imageName);
    return ['imageKey' => $imageKey , 'imageName' => $imageName];

}
}
if(!function_exists('uploadFile')){

    function uploadFile($file,$sender){       
       $filePath = $file->storeAs('/uploads/users/attachments/'.$sender, Carbon::now()->month .'_'.$sender.'.' .$file->getClientOriginalExtension());
       return $filePath;   
   }
}

    if(!function_exists('getFollowers')){

        function getFollowers($id){
           $followers = DB::table('follows')->where('target_id',$id)->get();
           $users = [];
           if(!empty($followers)){
               foreach($followers as $follower){
                   $users [] = User::where('id', $follower->follower_id)->first();
               }
           }    
           return $users;
        }
    }

    if(!function_exists('notifyUserOfFollower')){

        function notifyUserOfFollower($user_id, $follower_id){
            $user = User::where('id', $user_id)->first();
            $user->notify(new NewFollower(User::findOrFail($follower_id)));
            return 1;
        }
    }

?>