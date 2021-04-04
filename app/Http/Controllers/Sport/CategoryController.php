<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Sport_Models\Category;
use App\Sport_Models\Product;
use App\Sport_Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Term::whereHas('type', function ($q) {
            $q->where('taxonomy', 'category');
        })->paginate(10);
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