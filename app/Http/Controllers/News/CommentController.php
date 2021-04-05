<?php

namespace App\Http\Controllers\News;

use App\Comment;
use App\Http\Controllers\Controller;
use App\User;
use Arabic\Arabic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Notifications\NewComment;
use App\Product;
use App\WpLikeDislikeCounters;

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

        // return auth()->user();
        $messages =  [
            'post_id.required' => ' يجب  أختيار خبر موجود  ',
            'post_id.exists' => ' الخبر غير موجود ',
            'comment.required' => 'يجب أدخال  تعليق ',

        ];
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:mysql_new.wp_posts,ID',
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

        if (auth()->check()) {
            $comment = new Comment;

            $comment->comment_post_ID = $request->post_id;
            $comment->comment_content = $request->comment;
            $comment->comment_date = Carbon::now();
            $comment->comment_date_gmt = Carbon::now();

            $comment->comment_author = auth()->user()->username;
            $comment->comment_author_email = auth()->user()->email;
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


    public function storeReply(Request $request)
    {

        $messages =  [
            'post_id.required' => 'يجب  أدخال خبر  ',
            'post_id.exists' => ' الخبر غير موجود ',
            'comment.required' => 'يجب أدخال  تعليق ',

        ];
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:mysql_new.wp_posts,ID',
            'comment' => 'required',
            'comment_id' => 'required|exists:mysql_new.wp_comments,comment_ID'
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

        if (auth()->check()) {
            $comment = new Comment;

            $comment->comment_post_ID = $request->post_id;
            $comment->comment_content = $request->comment;
            $comment->comment_parent = $request->comment_id;
            $comment->comment_date = Carbon::now();
            $comment->comment_date_gmt = Carbon::now();

            $comment->comment_author = auth()->user()->username;
            $comment->comment_author_email = auth()->user()->email;
            $comment->save();
            return response()->json(['message' => 'تم التعليق بنجاح', 'data' => $comment], 200);
        }
        if ($request->username) {
            $comment = new Comment;

            $comment->comment_post_ID = $request->post_id;
            $comment->comment_content = $request->comment;
            $comment->comment_author = $request->username;
            $comment->comment_date_gmt = Carbon::now();
            $comment->comment_parent = $request->comment_id;

            $comment->comment_date = Carbon::now();
            $comment->save();

            return response()->json(['message' => 'تم التعليق بنجاح', 'data' => $comment], 200);
        } else {
            return response()->json(['data' => 'يجب إدخال أسم المستخدم'], 400);
        }
    }


    public function getReplies()
    {
        $comment = Comment::where('comment_parent', request('comment_id'))->get();
        return response()->json(['data' => $comment], 200);
    }


    public function likeComment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|exists:mysql_new.wp_comments,comment_ID'
        ]);


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
        $like_comment = WpLikeDislikeCounters::where('post_id', request('comment_id'))
            ->where('ul_key', 'c_like')
            ->first();
        if ($like_comment) {
            $like_comment->ul_value += 1;
            $like_comment->save();
        } else {
            $like = new WpLikeDislikeCounters;
            $like->ul_value = 1;
            $like->post_id = request('comment_id');
            $like->ul_key = 'c_like';
            $like->save();
        }
        return response()->json(['message' => 'تم'], 200);
    }

    public function disLikeComment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|exists:mysql_new.wp_comments,comment_ID'
        ]);


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
        $like_comment = WpLikeDislikeCounters::where('post_id', request('comment_id'))
            ->where('ul_key', 'c_dislike')
            ->first();
        if ($like_comment) {
            $like_comment->ul_value += 1;
            $like_comment->save();
        } else {
            $like = new WpLikeDislikeCounters;
            $like->ul_value = 1;
            $like->post_id = request('comment_id');
            $like->ul_key = 'c_dislike';
            $like->save();
        }
        return response()->json(['message' => 'تم'], 200);
    }
}
