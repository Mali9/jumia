<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Product Routes

Route::get('/products', 'ProductController@index');
Route::post('/create-product','ProductController@store');
Route::post('/add-images','ProductController@addProductImages');
Route::post('/delete-images','ProductController@removeProductImages');
Route::get('/product/{id}','ProductController@show');
Route::post('/update-product/{id}','ProductController@update');
Route::delete('/delete-product/{id}','ProductController@destroy');


// User Routes

Route::get('/user/{id}','UserController@show');
Route::post('/report-user','UserController@reportUser');
Route::post('/comment','UserController@comment');


//login - logout - register

Route::post('/login', 'LoginController@Login')->name('login');
Route::post('/register', 'LoginController@register');
Route::post('/logout', 'LoginController@Logout');


//Category routes

Route::get('/categories', 'CategoryController@index'); 
Route::get('/sub-categories/{id}', 'CategoryController@getSubCategories');
Route::get('/custom-fields/{id}', 'CategoryController@getAdditionalFields');

