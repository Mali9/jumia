<?php

namespace App\Http\Controllers\Admin;

use App\Suggestion;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuggestionController extends Controller
{

    protected $request;
    protected $suggestion;
    public function __construct(Request $request, Suggestion $suggestion)
    {
        $this->request = $request;
        $this->suggestion = $suggestion;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-suggestions')) {
            return view('forbidden_page');
        }

        $suggestions = $this->suggestion->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $suggestions = $suggestions->where('body', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $suggestions = $suggestions->paginate(10);
            return view('admin.suggestions.partial.partial', compact('suggestions'));
        }
        $suggestions = $suggestions->paginate(10);

        return view('admin.suggestions.index', compact('suggestions'));
    }

    public function createReply($suggestion_id)
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('reply-suggestions')) {
            return view('forbidden_page');
        }
        return view('admin.suggestions.reply', compact('suggestion_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function storeReply()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('reply-suggestions')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'reply' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }

            return redirect()->back()->withErrors($validator->errors());
        }
        $t = time();
        $c_time = date("Y-m-d", $t);

        $suggestion = $this->suggestion->find($this->request->suggestion_id);
        $suggestion->reply = $this->request->reply;
        $suggestion->replyed_at = $c_time;
        $suggestion->save();
        if ($suggestion) {
            return redirect('/all-suggestions')->with('success', 'تم الرد على الإقتراح بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-suggestions')) {
            return view('forbidden_page');
        }
        $suggestion = $this->suggestion->findOrFail($id);
        if ($suggestion->delete()) {
            return redirect()->back()->with('success', 'تم حذف الإقتراح بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
