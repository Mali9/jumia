<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use Arabic\Arabic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id)
    {
        $products = Product::where('category_id',$category_id)->where('is_published',1)->get();
        return response()->json(['data' => $products],200);
    }

    public function getAdditionalFields($category_id)
    {
        $additional_Fields = DB::table('fields')->where('category_id',$category_id)->get();
        return response()->json(['data' => $additional_Fields],200);
    }

    public function addProductImages(Request $request)
    {
        $num_of_images_per_product = 5;
        $product = Product::where('id',$request->product_id)->first();
        $new_images = [];
        if($product->images == null){
            foreach($request->images as $image) { 
                $path = saveImage($image);
                $new_images [$path['imageKey']] = $path['imageName'];
            }
            $new_images = json_encode($new_images);
            
            $product['images'] = $new_images;
            $product->save();
            return response()->json(['data' => 'Images added'],200);
        }

        $existing_images = json_decode($product->images);
        if((count($existing_images) + count($request->images)) <= $num_of_images_per_product){
            foreach($request->images as $image) { 
                $path = saveImage($image);
                $new_images [] = [$path['imageKey'] => $path['imageName']];
            }
            $images = array_merge($existing_images,$new_images);
            $images = json_encode($images);
            $product['images'] = $images;
            $product->save();
            return response()->json(['data' => 'Images added'],200);
        }else{
            return response()->json(['data' => 'Limit is 5 images'],400);

        }

    }

    public function removeProductImages(Request $request)
    {
        $product = Product::where('id',$request->product_id)->first();
        $images = json_decode($product->images,true);
        $keys = $request->image_names;
        $paths = $request->image_paths;
        for ($i=0; $i < count($keys); $i++) { 
            unset($images[$keys[$i]]);
            unlink(public_path('uploads/products/'.$paths[$i]));
        }
        if(count($images) == 0){
            $product->images = null;
            $product->save();
        }
        $product->images = json_encode($images);
        $product->save();
        return response()->json(['data' => 'Image removed'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->additional_fields; //array that holds arrays of [id => value]
        $product['title'] = $request->title;
        $product['description'] = $request->description;
        $product['price'] = $request->price;
        $product['user_id'] = auth()->guard('api')->id();
        $product['category_id'] = $request->category_id;        
        Product::create($product);
        $latest_product = DB::table('products')->where('user_id',auth()->guard('api')->id())->latest()->first();

        if($fields != null){
            foreach ($fields as $field) {
                array_push($field,$latest_product->id, $latest_product->category_id);
                $field['created_at'] = Carbon::now();
                DB::table('product_field_values')->insert($field);
            }
        }
        
        return response()->json(['data' => $latest_product],200);
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
        $comments = (array) DB::table('comments')->select('user_id','comment','created_at')->where('product_id',$id)->get();
        foreach($comments as $comment){
            $creation_date = Carbon::parse($comment['created_at']);
            $comment['how_long_ago'] = 'منذ '. Arabic::since($creation_date);
            $comment['user'] = User::select('id','image','name')->where('id',$comment['user_id'])->first();
        }
        $fields = (array) DB::table('fields')->select('id','display_name')->where('category_id',$product->category_id)->get();
        $field_values = (array) DB::table('product_field_values')->select('value')->where('product_id',$product->id)->get();
        $product['fields'] = $fields;
        $product['field_values'] = $field_values;
        $product['comments'] = $comments;
        return response()->json(['data' => $product],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = $request->additional_fields;
        $product = Product::where('id',$id)->first();
        $product['title'] = $request->title;
        $product['description'] = $request->description;
        $product['price'] = $request->price;
        $product['user_id'] = auth()->guard('api')->id();


        if($request->category_id != $product['category_id']){
            DB::table('product_field_values')->where('product_id',$id)->delete();
            $product['category_id'] = $request->category_id;
        }

        if($fields != null){
            foreach ($fields as $field) {
                array_push($field,$product->id, $product->category_id);
                $field['created_at'] = Carbon::now();
                DB::table('product_field_values')->insert($field);
            }
        }
        

        if($product['is_published'] == 1){
            $product['is_published'] = 0;
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
        DB::table('product_field_values')->where('product_id',$id)->delete();
        Product::destroy($id);
        return response()->json(['data' => 'Successfully deleted'],200);
    }
}
