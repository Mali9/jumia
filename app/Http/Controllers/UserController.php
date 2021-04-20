<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\json_decode;

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

        return response()->json(['data' => auth()->user()], 200);
    }


    public function UpdateProfile(Request $request)
    {


        // return (auth()->user());
        $validator = Validator::make(request()->all(), [
            'fullname' => 'required|max:100',
            'username' => 'required|unique:users,username,' . auth()->user()->id,
            'email' => 'required|max:100|email|unique:users,email,' . auth()->user()->id,
            'password' => 'required|min:6|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);


        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $error) {
                $errors[$index] = $error[0];
                $index++;
            }
            return response()->json(['errors' => $errors], 400);
        }

        $user = User::find(auth()->user()->id);
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if (isset(request()->image) && !empty(request()->image)) {
            $image_path = 'uploads/users/' . $user->image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = Helper::upload_user_image(request()->image);
            $user->image = $imageName;
        }
        $user->save();
        return response()->json(['message' => 'تم تحديث بيانات المستحدم بنجاح', 'data' => $user], 200);
    }
}
