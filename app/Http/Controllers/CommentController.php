<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Arabic\Arabic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Notifications\NewComment;
use App\Product;

class CommentController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $messages =  [
            'post_id.required' => 'يجب  أدخال خبر  ',
            'post_id.exists' => ' الخبر غير موجود ',
            'comment.required' => 'يجب أدخال  تعليق ',

        ];
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:wp_posts,ID',
            'comment' => 'required'
        ], $messages);


        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors['errors'][$index]['key'] = $key;
                $errors['errors'][$index]['error'] = $error[0];
                $index++;
            }

            return response()->json(['data' => $errors], 400);
        }

        if (auth()->guard('api')->check()) {
            $comment = new Comment;

            $comment->comment_post_ID = $request->post_id;
            $comment->comment_content = $request->comment;
            $comment->comment_date = Carbon::now();
            $comment->comment_date_gmt = Carbon::now();

            $comment->comment_author = auth()->guard('api')->user()->user_nicename;
            $comment->comment_author_email = auth()->guard('api')->user()->user_email;
            $comment->save();
            return response()->json(['message' => 'تم التعليق بنجاح', 'data' => $comment], 200);
        }
        if ($request->username) {
            $comment = new Comment;

            $comment->comment_post_ID = $request->post_id;
            $comment->comment_content = $request->comment;
            $comment->comment_author = $request->username;
            $comment->comment_date_gmt = Carbon::now();

            $comment->comment_date = Carbon::now();
            $comment->save();

            return response()->json(['message' => 'تم التعليق بنجاح', 'data' => $comment], 200);
        } else {
            return response()->json(['data' => 'يجب إدخال أسم المستخدم'], 400);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'blog_article_id', 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $comment = Articlecomment::findOrFail($id);
        $comment['blog_article_id'] = $request['blog_article_id'];
        $comment['user_id'] = auth()->guard('api')->id();
        $comment['comment'] = $request['comment'];
        $comment->save();

        return response()->json(['data' => 'successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Articlecomment::findOrFail($id);
        if ($comment->user_id == auth()->guard('api')->id()) {
            Articlecomment::destroy($id);
            return response()->json(['data' => 'deleted successfully'], 200);
        }
        return response()->json(['data' => 'Unauthorized'], 401);
    }
}
