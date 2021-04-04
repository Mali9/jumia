<?php

namespace App\Http\Controllers\Admin;

use App\Violation;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViolationController extends Controller
{

    protected $request;
    protected $violation;
    public function __construct(Request $request, Violation $violation)
    {
        $this->request = $request;
        $this->violation = $violation;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-violations')) {
            return view('forbidden_page');
        }

        $violations = $this->violation->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $violations = $violations->where('body', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $violations = $violations->paginate(10);
            return view('admin.violations.partial.partial', compact('violations'));
        }
        $violations = $violations->paginate(10);

        return view('admin.violations.index', compact('violations'));
    }

    public function createReply($violation_id)
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('reply-violations')) {
            return view('forbidden_page');
        }
        return view('admin.violations.reply', compact('violation_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function storeReply()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('reply-violations')) {
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

        $violation = $this->violation->find($this->request->violation_id);
        $violation->reply = $this->request->reply;
        $violation->replyed_at = $c_time;
        $violation->save();
        if ($violation) {
            return redirect('/all-violations')->with('success', 'تم الرد على الشكوى بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\violation  $violation
     * @return \Illuminate\Http\Response
     */





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-violations')) {
            return view('forbidden_page');
        }
        $violation = $this->violation->findOrFail($id);
        if ($violation->delete()) {
            return redirect()->back()->with('success', 'تم حذف الشكوى بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
