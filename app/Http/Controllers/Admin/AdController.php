<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
    protected $request;
    protected $ad;
    public function __construct(Request $request, Ad $ad)
    {
        $this->request = $request;
        $this->ad = $ad;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-ads')) {
            return view('forbidden_page');
        }

        $ads = $this->ad->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $ads = $ads->where('title', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $ads = $ads->paginate(10);
            return view('admin.ads.partial.partial', compact('ads'));
        }
        $ads = $ads->paginate(10);

        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-ads')) {
            return view('forbidden_page');
        }
        $ads = ad::all();
        return view('admin.ads.create', compact('ads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-ads')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'title' => 'required',
            'url' => 'required',
            'image' => 'required|image',
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

        $ad = $this->ad;
        $ad->title = $this->request->title;
        $ad->url = $this->request->url;
        if (isset($this->request->image) && !empty($this->request->image)) {
            $imageName = Helper::upload_ad_image($this->request->image);
            $ad->image = $imageName;
        }
        $ad->save();
        if ($ad) {
            return redirect('/all-ads')->with('success', 'تم إضافة الاعلان بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ad  $ad
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        if ($id == 1 && auth()->user()->id != 1) {
            return view('forbidden_page');
        }
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-ads')) {
            return view('forbidden_page');
        }

        $ad = $this->ad->findOrFail($id);
        return view('admin.ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-ads')) {
            return view('forbidden_page');
        }

        $validator = Validator::make($this->request->all(), [
            'title' => 'required',
            'url' => 'required',
            'image' => 'image',
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

        $ad = $this->ad->find($this->request->ad_id);
        $ad->title = $this->request->title;
        $ad->url = $this->request->url;
        if (isset($this->request->image) && !empty($this->request->image)) {
            $imageName = Helper::upload_ad_image($this->request->image);
            $ad->image = $imageName;
        }
        $ad->save();
        if ($ad) {
            return redirect('/all-ads')->with('success', 'تم تعديل الاعلان بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-ads')) {
            return view('forbidden_page');
        }
        $ad = $this->ad->findOrFail($id);
        if ($ad->delete()) {
            return redirect()->back()->with('success', 'تم حذف الاعلان بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
