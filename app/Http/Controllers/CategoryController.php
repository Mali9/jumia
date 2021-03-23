<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Term::whereHas('type', function ($q) {
            $q->where('taxonomy', 'category');
        })->paginate(2);
        return response()->json(['data' => $categories], 200);
    }

    public function getSubCategories($id)
    {
        $subcategories = DB::table('categories')->select('id', 'name')->where('parent_id', $id)->get();
        $products = Product::where('category_id', $id)->get();
        $category['subcategories'] = $subcategories;
        $category['products'] = $products;
        return response()->json(['data' => $category], 200);
    }

  
}
