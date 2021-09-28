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


// new 

Route::group(['namespace' => 'News'], function () {
    Route::get('/posts', 'PostController@index');
    Route::get('/related_posts', 'PostController@relatedPosts');
    Route::get('/show_post/{id}/{user_id?}', 'PostController@show');
    Route::get('/search', 'PostController@Search');
    Route::get('/posts_by_category', 'PostController@postsByCategory');


    // get_page contenct
    Route::get('/get_page/{id}', 'PostController@getPageContent');



    // categories

    Route::get('/categories', 'CategoryController@index');




    // comments routes
    Route::post('/store_comment', 'CommentController@store');
    Route::post('/store_reply', 'CommentController@storeReply');
    Route::get('/comment_replies', 'CommentController@getReplies');
    Route::post('/like_comment', 'CommentController@likeComment')->middleware('auth:api');
    Route::post('/dislike_comment', 'CommentController@disLikeComment')->middleware('auth:api');
    Route::post('/report_comment', 'CommentController@reportComment');
});



// sports routes



Route::group(['prefix' => 'sport', 'namespace' => 'Sport'], function () {
    Route::get('/posts', 'PostController@index');
    Route::get('/related_posts', 'PostController@related');
    Route::get('/show_post/{id}/{user_id?}', 'PostController@show');
    Route::get('/search', 'PostController@Search');
    Route::get('/posts_by_category', 'PostController@postsByCategory');


    // get_page contenct
    Route::get('/get_page/{id}', 'PostController@getPageContent');


    // categories

    Route::get('/categories', 'CategoryController@index');


    // comments routes
    Route::post('/store_comment', 'CommentController@store');
    Route::post('/store_reply', 'CommentController@storeReply');
    Route::get('/comment_replies', 'CommentController@getReplies');
    Route::post('/like_comment', 'CommentController@likeComment')->middleware('auth:api');
    Route::post('/dislike_comment', 'CommentController@disLikeComment')->middleware('auth:api');
    Route::post('/report_comment', 'CommentController@reportComment');
});

// packages

Route::get('/all_packages', 'PackageController@index');

Route::post('/get_result/{package_id}/{user_id}', 'PackageController@getPaymentResult');
Route::group(
    ['middleware' => 'auth:api'],
    function () {
        Route::get('subscription', 'PackageController@userSubscription');

        Route::get('/payment', 'PackageController@payment');

        Route::get('/my_profile', 'UserController@myProfile');
        Route::post('/update_profile', 'UserController@UpdateProfile');



        Route::get('/my_subscribtions', 'PackageController@mySubscribtions');
        Route::post('/logout', 'LoginController@Logout');
        Route::post('/save_device_token', 'Admin\NotificationController@saveToken');
    }
);
