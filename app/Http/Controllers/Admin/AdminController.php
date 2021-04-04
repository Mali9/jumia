<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Competition;
use App\Complaint;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Question;
use App\User;
use App\Violation;
use App\Helpers\Helper;

class AdminController extends Controller
{


    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }



    public function index()
    {
        // $users = $this->user->where('type', 'user')->count();
        // $best_earned = $this->user->whereRaw('credit = (select max(`credit`) from users)')->first();
        // $complaints = Complaint::count();
        // $questions = Question::count();
        // $violations = Violation::count();
        // $total_earned_today  = Competition::whereDate('created_at', \Carbon\Carbon::today())->get()->Sum('total_earned');
        // $total_users_credits = $this->user->where('type', 'user')->get()->Sum('credit');
        // // dd($total_users_credits);
        // $males = $this->user->where('type', 'user')->where('gender', 'male')->count();
        // $females = $this->user->where('type', 'user')->where('gender', 'female')->count();
        // $countries_ids = $this->user->where('type', 'user')->get()->unique('country_id')->pluck('country_id')->toArray();

        // $countries = Country::whereIn('id', $countries_ids)->count();
        return view('admin.index');
    }
}
