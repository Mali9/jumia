<?php

namespace App\Http\Controllers\Admin;

use App\Bar;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarController extends Controller
{
    protected $request;
    protected $bar;
    public function __construct(Request $request, Bar $bar)
    {
        $this->request = $request;
        $this->bar = $bar;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-bars')) {
            return view('forbidden_page');
        }

        $bars = $this->bar->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $bars = $bars->where('body', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $bars = $bars->paginate(10);
            return view('admin.bars.partial.partial', compact('bars'));
        }
        $bars = $bars->paginate(10);

        return view('admin.bars.index', compact('bars'));
    }

    public function create()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-bars')) {
            return view('forbidden_page');
        }
        $bars = bar::all();
        return view('admin.bars.create', compact('bars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-bars')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'body' => 'required',
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

        $bar = $this->bar;
        $bar->body = $this->request->body;
        $bar->save();
        if ($bar) {
            return redirect('/all-bars')->with('success', 'تم إضافة شريط الأخبار بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\bar  $bar
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-bars')) {
            return view('forbidden_page');
        }

        $bar = $this->bar->findOrFail($id);
        return view('admin.bars.edit', compact('bar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-bars')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'body' => 'required',
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


        $bar = $this->bar->find($this->request->bar_id);
        $bar->body = $this->request->body;


        $bar->save();
        if ($bar) {
            return redirect('/all-bars')->with('success', 'تم تعديل شريط الأخبار بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bar  $bar
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-bars')) {
            return view('forbidden_page');
        }
        $bar = $this->bar->findOrFail($id);
        if ($bar->delete()) {
            return redirect()->back()->with('success', 'تم حذف شريط الأخبار بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
