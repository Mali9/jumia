<?php

namespace App\Http\Controllers\Admin;

use App\Transfer;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class TransferController extends Controller
{

    protected $request;
    protected $transfer;
    public function __construct(Request $request, Transfer $transfer)
    {
        $this->request = $request;
        $this->transfer = $transfer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-transfers')) {
            return view('forbidden_page');
        }

        $transfers = $this->transfer->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $transfers = $transfers->whereHas('sender', function ($q) {
                    return $q->where('fullname', 'LIKE', '%' . $this->request->keyword . '%');
                });

                $transfers = $transfers->orWhereHas('reciever', function ($q) {
                    return $q->where('fullname', 'LIKE', '%' . $this->request->keyword . '%');
                });
            }
            $transfers = $transfers->with('sender', 'reciever')->paginate(10);
            return view('admin.transfers.partial.partial', compact('transfers'));
        }
        $transfers = $transfers->with('sender', 'reciever')->paginate(10);
        return view('admin.transfers.index', compact('transfers'));
    }
}
