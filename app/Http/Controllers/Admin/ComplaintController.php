<?php

namespace App\Http\Controllers\Admin;

use App\Complaint;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{

    protected $request;
    protected $complaint;
    public function __construct(Request $request, Complaint $complaint)
    {
        $this->request = $request;
        $this->complaint = $complaint;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-complaints')) {
            return view('forbidden_page');
        }

        $complaints = $this->complaint->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $complaints = $complaints->where('body', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $complaints = $complaints->paginate(10);
            return view('admin.complaints.partial.partial', compact('complaints'));
        }
        $complaints = $complaints->paginate(10);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function createReply($complaint_id)
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('reply-complaints')) {
            return view('forbidden_page');
        }
        return view('admin.complaints.reply', compact('complaint_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function storeReply()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('reply-complaints')) {
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

        $complaint = $this->complaint->find($this->request->complaint_id);
        $complaint->reply = $this->request->reply;
        $complaint->replyed_at = $c_time;
        $complaint->save();
        if ($complaint) {
            return redirect('/all-complaints')->with('success', 'تم الرد على الشكوى بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\complaint  $complaint
     * @return \Illuminate\Http\Response
     */





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-complaints')) {
            return view('forbidden_page');
        }
        $complaint = $this->complaint->findOrFail($id);
        if ($complaint->delete()) {
            return redirect()->back()->with('success', 'تم حذف الشكوى بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
