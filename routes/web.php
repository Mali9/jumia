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




Route::get('/', function () {
    return view('welcome');
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

    Route::get('/all-packages', 'packageController@index');
    Route::get('/edit_package/{id}', 'packageController@edit');
    Route::post('/update_package', 'packageController@update');
    Route::get('/packages/{question_id}', 'packageController@getQuestionpackages');



    //Site Settings

    Route::get('/conditions', 'ConditionController@index');
    Route::post('/udpate_conditions', 'ConditionController@update');


    // sms emails

    Route::get('/mail_form', 'UserMailController@mailForm');
    Route::post('/send_mail', 'UserMailController@sendMail');


    //site settings

    Route::get('/site_settings', 'SiteSettingsController@index');
    Route::post('/update_site_settings', 'SiteSettingsController@update');





    // logout 
    Route::get('logout', 'AuthController@logout')->name('logout');
});
