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
// reset password with email
Route::post('forget/password', 'ResetController@forgetPassword');
Route::post('change_password', 'ResetController@ChangePassword');


// reset username with email
Route::post('forget/username', 'ResetController@forgetUsername');

// auth routes
Route::post('/login', 'LoginController@Login')->name('login');
Route::post('/register', 'LoginController@register');


Route::get('/posts', 'PostController@index');
Route::get('/related_posts', 'PostController@related');
Route::get('/show_post/{id}', 'PostController@show');
Route::get('/search', 'PostController@Search');
Route::get('/posts_by_category', 'PostController@bostsByCategory');
Route::get('/categories', 'CategoryController@index');
Route::post('/store_comment', 'CommentController@store');



Route::group(
    ['middleware' => 'auth:api'],
    function () {

        Route::get('/my_profile', 'UserController@myProfile');
        Route::post('/logout', 'LoginController@Logout');
    }
);
