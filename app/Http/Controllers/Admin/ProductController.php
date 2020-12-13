<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('is_published','ASC')->get();
        return view('admin.products.index')->with('products',$products);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id',$id)->first();
        $category = Category::where('id',$product->category_id)->first();
        $product['category'] = $category;
        $product['images'] = json_encode($product['images']);
        return view('admin.products.show')->with('product',$product);
    }

   /**
     * Approve the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function approve($id)
    {
        $product = Product::where('id',$id)->get();
        $product->is_published = 1;
        $product->save();
        return redirect(action('ProductController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect(action('ProductController@index'));
    }
}
