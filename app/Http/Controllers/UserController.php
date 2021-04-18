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


    public function test()
    {
        $url = "https://test.oppwa.com/v1/payments";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=92.00" .
            "&currency=EUR" .
            "&paymentBrand=VISA" .
            "&paymentType=DB" .
            "&card.number=4200000000000000" .
            "&card.holder=Jane Jones" .
            "&card.expiryMonth=05" .
            "&card.expiryYear=2034" .
            "&card.cvv=123";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $id = json_decode($responseData)->id;
        return view('welcome', compact('id'));
    }

    public function success()
    {
        $url = "https://test.oppwa.com/v1/payments/" . request('id');
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        dd(json_decode($responseData));
    }
}
