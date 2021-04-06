<?php

namespace App\Http\Controllers\Sport;

use App\Sport_Models\Post;
use App\Http\Controllers\Controller;
use App\Sport_Models\Taxonomy;
use App\Sport_Models\Term;
use App\Sport_Models\WpTermRelationship;
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


    public function show($id)
    {
        $posts = Post::select('ID', 'post_date', 'post_content', 'post_title', 'post_name')
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
            ->first(10);
        return response()->json(['data' => $posts], 200);
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

    public function related()
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
