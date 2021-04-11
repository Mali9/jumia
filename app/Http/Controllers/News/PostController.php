<?php

namespace App\Http\Controllers\News;

use App\Post;
use App\Http\Controllers\Controller;
use App\Subscription;
use App\Taxonomy;
use App\Term;
use App\WpTermRelationship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::select('ID', 'post_date', 'post_content', 'post_title', 'post_name')
            ->where(['post_status' => 'publish', 'post_type' => 'post'])
            ->orderBy('post_date', 'desc')
            ->with(array('view' => function ($query) {
                $query->select('post_id', 'meta_value');
            }))
            ->with(array('comments' => function ($query) {
                $query->select('comment_post_ID', 'comment_author', 'comment_date', 'comment_content');
            }))
            ->withCount('comments')
            ->paginate(10);
        return response()->json(['data' => $posts], 200);
    }


    public function show($id, $user_id = null)
    {

        $post = Post::select('ID', 'post_date', 'post_content', 'post_title', 'post_name')
            ->where('ID', $id)
            ->where(['post_status' => 'publish', 'post_type' => 'post'])
            ->orderBy('post_date', 'desc')
            ->with(array('view' => function ($query) {
                $query->select('post_id', 'meta_value');
            }))
            ->with(array('comments' => function ($query) {
                $query->select('comment_post_ID', 'comment_author', 'comment_date', 'comment_content');
            }))
            ->withCount('comments')
            ->first();

        if (Carbon::now('Asia/Riyadh')->diffInHours($post->post_date) > $this->browsing_duration()) {

            $user_subscribe = Subscription::where('user_id', $user_id)
                ->whereDate('expired_at', '>=', Carbon::now())
                ->where('status', 1)
                ->orWhere('staff', 1)
                ->get();




            if (count($user_subscribe) == 0) {
                return response()->json(['data' => 'عفوا يجب عليك الإشتراك في أحدى الباقات'], 403);
            } else {
                return response()->json(['data' => $post], 200);
            }
        }



        return response()->json(['data' => $post], 200);
    }


    public function Search()
    {
        if (!request('keyword')) {
            return response()->json(['message' => 'من فضلك أدخل كلمة للبحث'], 400);
        }

        $posts = Post::select('ID', 'post_date', 'post_content', 'post_title', 'post_name')
            ->where(['post_status' => 'publish', 'post_type' => 'post'])
            ->where('post_content', 'LIKE', '%' . request('keyword') . '%')
            ->orWhere('post_title', 'LIKE', '%' . request('keyword') . '%')
            ->orderBy('post_date', 'desc')
            ->with(array('view' => function ($query) {
                $query->select('post_id', 'meta_value');
            }))
            ->with(array('comments' => function ($query) {
                $query->select('comment_post_ID', 'comment_author', 'comment_date', 'comment_content');
            }))
            ->withCount('comments')
            ->paginate(10);
        if (count($posts)) {
            return response()->json(['data' => $posts], 200);
        }
        return response()->json(['message' => 'لا يوجد نتائج بحث'], 400);
    }

    public function postsByCategory()
    {
        $posts = WpTermRelationship::where('term_taxonomy_id', request('category_id'))
            ->with('post')
            ->paginate(10);

        return response()->json(['data' => $posts], 200);
    }

    public function relatedPosts()
    {
        $category = WpTermRelationship::where('object_id', request('post_id'))->first();
        if ($category) {
            $posts = WpTermRelationship::where('term_taxonomy_id', $category->term_taxonomy_id)
                ->where('object_id', '!=', request('post_id'))
                ->with('post')
                ->paginate(10);

            return response()->json(['data' => $posts], 200);
        } else {
            return response()->json(['message' => 'لا يوجد نتائج '], 400);
        }
    }
}
