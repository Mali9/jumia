<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class CompetitionController extends Controller
{
    protected $request;
    protected $competition;
    public function __construct(Request $request, Competition $competition)
    {
        $this->request = $request;
        $this->competition = $competition;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-competitions')) {
            return view('forbidden_page');
        }

        $competitions = $this->competition->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $competitions = $competitions->whereHas('room', function ($q) {
                    return $q->where('id', 'LIKE', '%' . $this->request->keyword . '%');
                });

                $competitions = $competitions->orWhereHas('user', function ($q) {
                    return $q->where('fullname', 'LIKE', '%' . $this->request->keyword . '%');
                });
            }
            $competitions = $competitions->with('room', 'user')->paginate(10);
            return view('admin.competitions.partial.partial', compact('competitions'));
        }
        $competitions = $competitions->with('room', 'user')->paginate(10);
        return view('admin.competitions.index', compact('competitions'));
    }
}
