<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->select('id','name','parent_id')->orderBy('parent_id','ASC')->get();
        return response()->json(['data' => $categories],200);
    }

    public function getSubCategories($id)
    {
        $subcategories = DB::table('categories')->select('id','name')->where('parent_id',$id)->get();
        $products = Product::where('category_id',$id)->get();
        $category['subcategories'] = $subcategories;
        $category['products'] = $products;
        return response()->json(['data' => $category],200);
    }

    public function getAdditionalFields($category_id)
    {
        $fields = DB::table('fields')->
        select('id','name','display_name','type','values','required')->where('category_id',$category_id)->get();
        return response()->json(['data' => $fields],200);

    }
}
