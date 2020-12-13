<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Favorite;
use Illuminate\Support\Facades\Validator;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = [];
        $favorites = Favorite::where('user_id', '=', auth()->guard('api')->id())->get();
        foreach($favorites as $favorite){
            $product = Product::where('id', '=', $favorite->product_id)->get();
            $products [] = $product;
        }
        return response()->json(['data' => $products],200);
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
            'product_id' => 'required'
        ]);
        
        if($validator->fails()){
            return $validator->errors();
        }

        $favorite['user_id'] = auth()->guard('api')->id();

        Favorite::create($favorite);
        return response()->json(['data' => 'Successfully added to favorites'], 200);

    }


   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Favorite::where('product_id',$request['product_id'])->where('user_id',auth()->guard('api')->id())->destroy();
        
        return response()->json(['data'=>'Successfully removed from favorites'], 200);
    }
}
