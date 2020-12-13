<?php

use App\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', 'AdminController@index');

//Categories Routes (Admin panel)

Route::get('/categories', 'CategoryController@index');
Route::get('/categories/create', 'CategoryController@create');
Route::post('/categories', 'CategoryController@store');
Route::get('/category/{id}/edit', 'CategoryController@edit');
Route::post('/update-category', 'CategoryController@update');
Route::get('/category/{id}/delete', 'CategoryController@destroy');

//Fields Routes (Admin Panel)

Route::get('/fields', 'FieldController@index');
Route::get('/fields/create', 'FieldController@create');
Route::post('/fields', 'FieldController@store');
Route::get('/field/{id}/edit', 'FieldController@edit');
Route::post('/update-field', 'FieldController@update');
Route::get('/field/{id}/delete', 'FieldController@destroy');


//products routes (Admin panel)

Route::get('/products', 'ProductController@index');
Route::get('/product/{id}/show', 'ProductController@show');
Route::post('/approve-product/{id}', 'ProductController@approve');
Route::get('/delete-product/{id}', 'ProductController@index');
