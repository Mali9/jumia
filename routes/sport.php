<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'sport', 'namespace' => 'Sport'], function () {
    Route::get('/posts', 'PostController@index');
    Route::get('/related_posts', 'PostController@related');
    Route::get('/show_post/{id}', 'PostController@show');
    Route::get('/search', 'PostController@Search');
    Route::get('/posts_by_category', 'PostController@bostsByCategory');

    // categories

    Route::get('/categories', 'CategoryController@index');


    // comments routes
    Route::post('/store_comment', 'CommentController@store');
    Route::post('/store_reply', 'CommentController@storeReply');
    Route::get('/comment_replies', 'CommentController@getReplies');
    Route::post('/like_comment', 'CommentController@likeComment');
    Route::post('/dislike_comment', 'CommentController@disLikeComment');
});
