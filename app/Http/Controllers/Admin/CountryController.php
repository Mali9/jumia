<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Country;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class CountryController extends Controller
{

    protected $request;
    protected $country;
    public function __construct(Request $request, Country $country)
    {
        $this->request = $request;
        $this->country = $country;
    }

    public function index()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('show-countries')) {
            return view('forbidden_page');
        }

        $countries = $this->country->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $countries = $countries->where('name', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $countries = $countries->paginate(10);
            return view('admin.countries.partial.partial', compact('countries'));
        }
        $countries = $countries->paginate(10);

        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-countries')) {
            return view('forbidden_page');
        }
        $countries = Country::all();
        return view('admin.countries.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('create-countries')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|unique:countries,name',
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

        $country = $this->country;
        $country->name = $this->request->name;
        $country->save();
        if ($country) {
            return redirect('/all-countries')->with('success', 'تم إضافة البلد بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        if ($id == 1 && auth()->user()->id != 1) {
            return view('forbidden_page');
        }
        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-countries')) {
            return view('forbidden_page');
        }

        $country = $this->country->findOrFail($id);
        return view('admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function update()
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('edit-countries')) {
            return view('forbidden_page');
        }
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|unique:countries,name,' . $this->request->country_id,
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


        $country = $this->country->find($this->request->country_id);
        $country->name = $this->request->name;


        $country->save();
        if ($country) {
            return redirect('/all-countries')->with('success', 'تم تعديل البلد بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (auth()->user()->type != 'admin' && !Helper::checkPermissions('delete-countries')) {
            return view('forbidden_page');
        }
        $country = $this->country->findOrFail($id);
        if ($country->delete()) {
            return redirect()->back()->with('success', 'تم حذف البلد بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }
}
