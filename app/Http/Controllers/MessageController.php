<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $receivers_ids = Message::where('sender_id',auth()->guard('api')->id())->pluck('receiver_id');
        $senders_ids = Message::where('receiver_id',auth()->guard('api')->id())->pluck('sender_id');
        $users = User::whereIn('id', $receivers_ids)->orWhereIn('id',$senders_ids)->get();
        return response()->json(['data' => $users], 200);
    }

    public function loadMessages(Request $request)
    {
        $messages = DB::table('messages')->whereIn('sender_id', [ (integer) $request->user_id,auth()->guard('api')->id()])
        ->whereIn('receiver_id',[$request->user_id,auth()->guard('api')->id()]);

        return response()->json(['data' => $messages], 200);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'message' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }


        $user = auth()->guard('api')->user();
        $message['sender_id'] = auth()->guard('api')->id();
        $message['receiver_id'] = $request->user_id;
        $message['title'] = $request->title;
        $message['message'] = $request->message;
        if($request->hasFile('attachment')){
           $file = uploadFile($request->attachment, $user['name']);
            $message['attachment'] = $file;
        }
        Message::create($message);
        
        return response()->json(['data' => $message], 200);

    }

}
