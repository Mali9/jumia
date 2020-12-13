<?php

namespace App\Http\Controllers;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $comments = Product::where('blog_article_id',$id)->get();
        $count = count($comments);
        foreach($comments as $comment){
            $creation_date = Carbon::parse($comment['created_at']);
            $comment['how_long_ago'] = 'منذ '. Arabic::since($creation_date);
            $comment['user'] = User::select('id','image','name')->where('id',$comment['user_id'])->first();
        }
        
        $comments['count'] = $count;
        return response()->json(['data' => $comments],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
            'comment' => 'required'
        ]);

        $comment['user_id'] = auth()->guard('api')->id();
        $comment['product_id'] = $request->product_id;
        $comment['comment'] = $request->comment;
        $comment['created_at'] = Carbon::now();
        DB::table('comments')->insert($comment);
        $product_owner_id = DB::table('products')->select('user_id')->where('product_id',$request->product_id)->get();
        $product_owner = User::where('id',$product_owner_id)->first();
        $new_comment = DB::table('comments')->where('user_id',auth()->guard('api')->id())->latest()->first();
        $product_owner->notify(new NewComment($new_comment->id, $request->product_id));
        return response()->json(['data' => 'Commented successfully'], 200);
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
        $validator = Validator::make($request->all(),[
            'comment' => 'required',
            'blog_article_id','required'
        ]);
     
        if($validator->fails()){
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
        if($comment->user_id == auth()->guard('api')->id()){
            Articlecomment::destroy($id);
            return response()->json(['data' => 'deleted successfully'],200);
        }
        return response()->json(['data' => 'Unauthorized'],401);

    }
}
