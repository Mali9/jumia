<?php

namespace App\Http\Controllers\Sport;

use App\Sport_Models\Post;
use App\Http\Controllers\Controller;
use App\Sport_Models\Taxonomy;
use App\Sport_Models\Term;
use App\Sport_Models\WpTermRelationship;
use App\Subscription;
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
        $posts = Post::select('ID', 'post_author', 'post_date', 'post_content', 'post_title', 'post_name')
            ->where(['post_status' => 'publish', 'post_type' => 'post'])
            ->orderBy('post_date', 'desc')
            ->with(array('view' => function ($query) {
                $query->select('post_id', 'meta_value');
            }))
            ->with(array('comments' => function ($query) {
                $query->select('comment_ID', 'comment_post_ID', 'comment_author', 'comment_date', 'comment_content', 'comment_approved')
                    ->withCount('replies');
            }))
            ->withCount('comments')
            ->with('author')
            ->orderBy('post_date', 'desc')

            ->paginate(10);
        return response()->json(['data' => $posts], 200);
    }


    public function show($id, $user_id = null)
    {


        $post = Post::select('ID', 'post_author', 'post_date', 'post_content', 'post_title', 'post_name', 'post_status', 'post_type', 'comment_status')
            ->where('ID', $id)
            ->where(['post_status' => 'publish', 'post_type' => 'post'])
            ->orderBy('post_date', 'desc')
            ->with(array('view' => function ($query) {
                $query->select('post_id', 'meta_value');
            }))
            ->with(array('comments' => function ($query) {
                $query->select('comment_ID', 'comment_post_ID', 'comment_author', 'comment_date', 'comment_content', 'user_id', 'comment_approved')
                    ->withCount('replies');
            }))
            ->withCount('comments')
            ->with('author')
            ->first();

        if (!$post) {

            return response()->json(['data' => 'المحتوى غير موجود'], 404);
        }



        if (auth()->guard('api')->check()) {
            $user_id = auth()->guard('api')->user()->id;
            $user_subscribe = Subscription::where('user_id', $user_id)
                ->whereDate('expired_at', '>=', Carbon::now()->format('Y-m-d'))
                ->count();

            if ( Carbon::now('Asia/Riyadh')->diffInHours($post->post_date) < $this->browsing_duration() || 
                $user_subscribe > 0 ||  (auth()->guard('api')->user()->staff === 1 && auth()->guard('api')->user()->status === 1)) {
                return response()->json(['data' => $post], 200);
            } else {
                return response()->json(['data' => 'عفوا يجب عليك الإشتراك في أحدى الباقات'], 403);
            }
        }


        if (Carbon::now('Asia/Riyadh')->diffInHours($post->post_date) > $this->browsing_duration()) {
            return response()->json(['data' => 'عفوا يجب عليك الإشتراك في أحدى الباقات'], 403);
        } else {
            return response()->json(['data' => $post], 200);
        }
    }


    public function Search()
    {
        if (!request('keyword')) {
            return response()->json(['message' => 'من فضلك أدخل كلمة للبحث'], 400);
        }

        $posts = Post::select('ID', 'post_author', 'post_date', 'post_content', 'post_title', 'post_name', 'post_status', 'post_type')
            ->where(function ($query) {
                $query->where(['post_status' => 'publish', 'post_type' => 'post'])
                    ->where('post_content', 'LIKE', '%' . request('keyword') . '%');
            })
            ->orWhere(function ($query) {
                $query->orWhere('post_title', 'LIKE', '%' . request('keyword') . '%')
                    ->orderBy('post_date', 'desc');
            })
            ->with(array('view' => function ($query) {
                $query->select('post_id', 'meta_value');
            }))
            ->with(array('comments' => function ($query) {
                $query->select('comment_ID', 'comment_post_ID', 'comment_author', 'comment_date', 'comment_content', 'comment_approved')
                    ->withCount('replies');
            }))
            ->withCount('comments')
            ->with('author')
            ->orderBy('post_date', 'desc')

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
            ->orderBy('object_id', 'desc')
            ->paginate(10);

        return response()->json(['data' => $posts], 200);
    }

    public function related()
    {
        $category = WpTermRelationship::where('object_id', request('post_id'))->first();
        if ($category) {
            $posts = WpTermRelationship::where('term_taxonomy_id', $category->term_taxonomy_id)
                ->with('post')
                ->orderBy('object_id', 'desc')

                ->paginate(10);

            return response()->json(['data' => $posts], 200);
        } else {
            return response()->json(['message' => 'لا يوجد نتائج '], 400);
        }
    }
    public function getPageContent($id)
    {
        $page = Post::where('ID', $id)
            ->where('post_type', 'page')
            ->first();
        return response()->json(['data' => $page], 200);
    }
}
