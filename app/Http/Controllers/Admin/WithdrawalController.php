<?php

namespace App\Http\Controllers\Admin;

use App\Withdrawal;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class WithdrawalController extends Controller
{


    protected $request;
    protected $withdrawal;
    public function __construct(Request $request, Withdrawal $withdrawal)
    {
        $this->request = $request;
        $this->withdrawal = $withdrawal;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-withdrawals')) {
            return view('forbidden_page');
        }

        $withdrawals = $this->withdrawal->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $withdrawals = $withdrawals->whereHas('user', function ($q) {
                    return $q->where('fullname', 'LIKE', '%' . $this->request->keyword . '%');
                });
            }
            $withdrawals = $withdrawals->with('user')->paginate(10);
            return view('admin.withdrawals.partial.partial', compact('withdrawals'));
        }
        $withdrawals = $withdrawals->with('user')->paginate(10);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }
}
