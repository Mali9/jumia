<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Field;
use App\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::all();
        return view('admin.fields.index')->with('fields',$fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.fields.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'display-name' => 'required|string',
            'type' => 'required',
            'category_id' => 'required|numeric'
        ]);
        
        if($validator->fails()){
            return Redirect::to('/fields/create')->withErrors($validator)->withInput();
        }

        else{
            $field['name'] = $request->input('name');
            $field['category_id'] = $request->input('category_id');
            $field['display_name'] = $request->input('display-name');
            $field['type'] = $request->input('type');
            Field::create($field);
            return redirect(action('FieldController@index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Field::find($id);
        $category = Category::find($field->category_id);
        $categories = Category::all();
        $data = ['field' => $field, 'category'=> $category, 'categories' => $categories];
        return view('admin.fields.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $field = Field::findOrFail($request->field_id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'display-name' => 'required|string',
            'type' => 'required',
            'category_id' => 'required|numeric'
         ]);
     
         if($validator->fails()){
             return Redirect::to('/field'.'/'. $request->field_id . '/edit')->withErrors($validator)->withInput();
         }
         else{
            $field['name'] = $request->input('name');
            $field['category_id'] = $request->input('category_id');
            $field['display_name'] = $request->input('display-name');
            $field['type'] = $request->input('type');
            $field->update();
            return redirect(action('FieldController@index'));
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Field::destroy($id);
        Session::flash('message', 'Successfully deleted');
        return redirect(action('FieldController@index'));
    }
}
