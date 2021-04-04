<?php

namespace App\Http\Controllers\Admin;

use App\CreditCard;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class CreditCardController extends Controller
{
    protected $request;
    protected $credit_card;
    public function __construct(Request $request, CreditCard $credit_card)
    {
        $this->request = $request;
        $this->credit_card = $credit_card;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-credit_cards')) {
            return view('forbidden_page');
        }

        $credit_cards = $this->credit_card->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $credit_cards = $credit_cards->whereHas('user', function ($q) {
                    return $q->where('fullname', 'LIKE', '%' . $this->request->keyword . '%');
                });
            }
            $credit_cards = $credit_cards->with('user')->paginate(10);
            return view('admin.credit_cards.partial.partial', compact('credit_cards'));
        }
        $credit_cards = $credit_cards->with('user')->paginate(10);
        return view('admin.credit_cards.index', compact('credit_cards'));
    }
}
