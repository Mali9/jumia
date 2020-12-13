<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index')->with('categories',$categories);
    }

    public function create()
    {
        $parents = Category::all();
        return view('admin.categories.create')->with('parents',$parents);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'parentCategory' => 'required|numeric'
        ]);
        
        if($validator->fails()){
            return Redirect::to('/categories/create')->withErrors($validator)->withInput();
        }
        else{
            $category['name'] = $request->input('name');
            $category['parent_id'] = $request->input('parentCategory');
            Category::create($category);
            return redirect(action('CategoryController@index'));
        }

    }

    public function edit($id)
    {
        $category = Category::find($id);
        $parent = Category::find($category->parent_id);
        $parents = Category::all();
        $data = ['category'=> $category, 'parent' => $parent, 'parents' => $parents];
        return view('admin.categories.edit')->with('data', $data);
    }

    public function update(Request $request)
    {
       $category = Category::findOrFail($request->cat_id);
       $validator = Validator::make($request->all(),[
        'name' => 'required|string',
        'parentCategory' => 'required|numeric'
        ]);
    
        if($validator->fails()){
            return Redirect::to('/category'.'/'. $request->cat_id . '/edit')->withErrors($validator)->withInput();
        }
        else{
            $category['name'] = $request->input('name');
            $category['parent_id'] = $request->input('parentCategory');
            $category->update();
            return redirect(action('CategoryController@index'));
        }
    }

    public function destroy($id)
    {
        // delete
        Category::destroy($id);
        // redirect
        Session::flash('message', 'Successfully deleted');
        return redirect(action('CategoryController@index'));
    }
}
