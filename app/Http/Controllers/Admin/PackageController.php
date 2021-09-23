<?php

namespace App\Http\Controllers\Admin;

use App\Package;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\json_decode;

class PackageController extends Controller
{
    protected $request;
    protected $package;
    public function __construct(Request $request, Package $package)
    {
        $this->request = $request;
        $this->package = $package;
    }

    public function index()
    {

        $packages = $this->package->query();
        if ($this->request->ajax()) {
            if ($this->request->keyword) {
                $packages = $packages->where('name', 'LIKE', '%' . $this->request->keyword . '%');
            }
            $packages = $packages->orderBy('id')->paginate(10);

            return view('admin.packages.partial.partial', compact('packages'));
        }
        $packages = $packages->orderBy('id', 'desc')->paginate(10);
        // dd($packages[0]->description[0]);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {


        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Rvequest  $this->request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $validator = Validator::make($this->request->all(), [
            'price' => 'required|min:1',
            'duration' => 'required|min:1',
            'description' => 'required|min:1',
            'name' => 'required|unique:packages,name',
        ]);
        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }

            return redirect()->back()->withErrors($validator->errors())->withInput();
        }



        $package = $this->package;
        $package->price = $this->request->price;
        $package->duration = $this->request->duration;
        $package->description = json_encode($this->request->description);
        $package->name = $this->request->name;

        $package->save();

        if ($package) {
            return redirect('/all-packages')->with('success', 'تم إضافة الباقة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $package = $this->package->find($id);

        return view('admin.packages.single_package', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $package = package::findOrFail($id);
        if ($package->type == 'admin') {
            abort(403);
        }
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $this->request
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function update()
    {


        $validator = Validator::make($this->request->all(), [
            'price' => 'required|min:1',
            'duration' => 'required|min:1',
            'description' => 'required|min:1',
            'name' => 'required|unique:packages,name,' . $this->request->package_id,
        ]);
        if ($validator->fails()) {
            $errors = [];
            $index = 0;

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[$index] = $error[0];
                $index++;
            }

            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $package = $this->package->find($this->request->package_id);


        $package->price = $this->request->price;
        $package->duration = $this->request->duration;
        $package->description = json_encode($this->request->description);
        $package->name = $this->request->name;
        $package->save();
        if ($package) {
            return redirect('/all-packages')->with('success', 'تم تعديل الباقة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $package = package::findOrFail($id);
        if ($package->type == 'admin') {
            abort(403);
        }
        if ($package->delete()) {
            return redirect()->back()->with('success', 'تم حذف الباقة بنجاح');
        } else {
            return redirect()->back()->with('error', 'خطأ ');
        }
    }



    public function changepackageStatus($id)
    {

        $package = package::findOrFail($id);
        if ($package->type == 'admin') {
            abort(403);
        }
        if ($package->status == 0) {
            $package->status = 1;
        } else {
            $package->status = 0;
        }
        $package->save();
        return redirect('/all-packages')->with('success', 'تم تعديل الباقة بنجاح');
    }
}
