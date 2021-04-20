<?php

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

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    return redirect()->back();
});








Route::get('/', 'Admin\AuthController@admin_login')->name('login');
Route::post('/admin_login', 'Admin\AuthController@login');
Route::group(['middleware' => ['auth'], 'namespace' => 'Admin'], function () {

    Route::get('/dashboard', 'AdminController@index');





    //Users Routes
    Route::get('/all-users', 'UserController@index');
    Route::get('/show_user/{id}', 'UserController@show');
    Route::get('/add_user', 'UserController@create');
    Route::post('/store_user', 'UserController@store');
    Route::get('/edit_user/{id}', 'UserController@edit');
    Route::post('/update_user', 'UserController@update');
    Route::get('/change_user_status/{id}', 'UserController@changeUserStatus');
    Route::get('/delete_user/{id}', 'UserController@delete');




    //packages 

    Route::get('/all-packages', 'PackageController@index');
    Route::get('/edit_package/{id}', 'PackageController@edit');
    Route::get('/add_package', 'PackageController@create');
    Route::post('/store_package', 'PackageController@store');
    Route::post('/update_package', 'PackageController@update');
    Route::get('/delete_package/{id}', 'PackageController@delete');




    //subscriptions 


    Route::get('/all-subscriptions', 'SubscriptionController@index');
    Route::get('/edit_subscription/{id}', 'SubscriptionController@edit');
    Route::get('/add_subscription', 'SubscriptionController@create');
    Route::post('/store_subscription', 'SubscriptionController@store');
    Route::post('/update_subscription', 'SubscriptionController@update');
    Route::get('/delete_subscription/{id}', 'SubscriptionController@delete');
    Route::get('/change_subscription_status/{id}', 'SubscriptionController@changesubscriptionStatus');



    //Site Settings

    Route::get('/conditions', 'ConditionController@index');
    Route::post('/udpate_conditions', 'ConditionController@update');


    // notifications

    Route::get('/notifications', 'NotificationController@index');
    Route::post('/send_notification', 'NotificationController@sendNotification')->name('send.notification');


    //site settings

    Route::get('/site_settings', 'SiteSettingsController@index');
    Route::post('/update_site_settings', 'SiteSettingsController@update');





    // logout 
    Route::get('logout', 'AuthController@logout')->name('logout');
});
