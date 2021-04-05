<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Comment;
use App\Competition;
use App\Complaint;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Question;
use App\User;
use App\Violation;
use App\Helpers\Helper;
use App\NewsUser;
use App\Post;
use App\Sport_Models\Comment as Sport_ModelsComment;
use App\Sport_Models\Post as Sport_ModelsPost;
use App\Sport_Models\User as Sport_ModelsUser;

class AdminController extends Controller
{


    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }



    public function index()
    {
        $news_users = NewsUser::count();
        $sport_users = Sport_ModelsUser::count();
        $app_users = User::count();

        $news_post = Post::count();
        $sport_post = Sport_ModelsPost::count();

        $news_comments = Comment::count();
        $sport_comments = Sport_ModelsComment::count();

        return view('admin.index', compact(
            'news_users',
            'sport_users',
            'app_users',
            'news_post',
            'sport_post',
            'news_comments',
            'sport_comments'

        ));
    }
}
