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

    //Countries routes

    Route::get('/all-countries', 'CountryController@index');
    Route::get('/countries/create', 'CountryController@create');
    Route::post('/add_country', 'CountryController@store');
    Route::get('/country/{id}/edit', 'CountryController@edit');
    Route::post('/update_country', 'CountryController@update');
    Route::get('/country/{id}/delete', 'CountryController@delete');



    //Users Routes
    Route::get('/all-users', 'UserController@index');
    Route::get('/show_user/{id}', 'UserController@show');
    Route::get('/add_user', 'UserController@create');
    Route::post('/store_user', 'UserController@store');
    Route::get('/edit_user/{id}', 'UserController@edit');
    Route::post('/update_user', 'UserController@update');
    Route::get('/change_user_status/{id}', 'UserController@changeUserStatus');
    Route::get('/delete_user/{id}', 'UserController@delete');

    //competitors Routes
    Route::get('/all-competitors/{type?}', 'CompetitorController@index');
    Route::get('/all-competitors-credits', 'CompetitorController@competitorsCredits');
    Route::get('/show_competitor/{id}', 'CompetitorController@show');
    Route::get('/add_competitor', 'CompetitorController@create');
    Route::post('/store_competitor', 'CompetitorController@store');
    Route::get('/edit_competitor/{id}', 'CompetitorController@edit');
    Route::post('/update_competitor', 'CompetitorController@update');
    Route::get('/change_competitor_status/{id}', 'CompetitorController@changeCompetitorStatus');
    Route::get('/delete_competitor/{id}', 'CompetitorController@delete');

    //questions Routes
    Route::get('/all-questions', 'QuestionsController@index');
    Route::get('/show_question/{id}', 'QuestionsController@show');
    Route::get('/add_question', 'QuestionsController@create');
    Route::post('/store_question', 'QuestionsController@store');
    Route::get('/edit_question/{id}', 'QuestionsController@edit');
    Route::post('/update_question', 'QuestionsController@update');
    Route::get('/delete_question/{id}', 'QuestionsController@delete');


    //answers 

    Route::get('/all-answers', 'AnswerController@index');
    Route::get('/edit_answer/{id}', 'AnswerController@edit');
    Route::post('/update_answer', 'AnswerController@update');
    Route::get('/answers/{question_id}', 'AnswerController@getQuestionAnswers');



    //ads Routes
    Route::get('/all-ads', 'AdController@index');
    Route::get('/show_ad/{id}', 'AdController@show');
    Route::get('/add_ad', 'AdController@create');
    Route::post('/store_ad', 'AdController@store');
    Route::get('/edit_ad/{id}', 'AdController@edit');
    Route::post('/update_ad', 'AdController@update');
    Route::get('/delete_ad/{id}', 'AdController@delete');


    //bars Routes
    Route::get('/all-bars', 'BarController@index');
    Route::get('/show_bar/{id}', 'BarController@show');
    Route::get('/add_bar', 'BarController@create');
    Route::post('/store_bar', 'BarController@store');
    Route::get('/edit_bar/{id}', 'BarController@edit');
    Route::post('/update_bar', 'BarController@update');
    Route::get('/delete_bar/{id}', 'BarController@delete');


    //rooms Routes
    Route::get('/all-rooms', 'RoomController@index');
    Route::get('/show_room/{id}', 'RoomController@show');
    Route::get('/add_room', 'RoomController@create');
    Route::post('/store_room', 'RoomController@store');
    Route::get('/edit_room/{id}', 'RoomController@edit');
    Route::post('/update_room', 'RoomController@update');
    Route::get('/delete_room/{id}', 'RoomController@delete');


    //complaints Routes
    Route::get('/all-complaints', 'ComplaintController@index');
    Route::get('/create_reply/{id}', 'ComplaintController@createReply');
    Route::post('/store_reply', 'ComplaintController@storeReply');
    Route::get('/delete_complaint/{id}', 'ComplaintController@delete');

    //suggestion Routes
    Route::get('/all-suggestions', 'SuggestionController@index');
    Route::get('/create_suggestion_reply/{id}', 'SuggestionController@createReply');
    Route::post('/store_suggestion_reply', 'SuggestionController@storeReply');
    Route::get('/delete_suggestion/{id}', 'SuggestionController@delete');


    //Violations Routes
    Route::get('/all-violations', 'ViolationController@index');
    Route::get('/create_violation_reply/{id}', 'ViolationController@createReply');
    Route::post('/store_violation_reply', 'ViolationController@storeReply');
    Route::get('/delete_violation/{id}', 'ViolationController@delete');

    // transfers
    Route::get('/all-transfers', 'TransferController@index');

    // withdrawals
    Route::get('/all-withdrawals', 'WithdrawalController@index');

    // credit-cards
    Route::get('/all-credit-cards', 'CreditCardController@index');



    // competitions
    Route::get('/all-competitions', 'CompetitionController@index');

    //Site Settings

    Route::get('/conditions', 'ConditionController@index');
    Route::post('/udpate_conditions', 'ConditionController@update');


    // sms emails

    Route::get('/mail_form', 'UserMailController@mailForm');
    Route::post('/send_mail', 'UserMailController@sendMail');



    Route::get('/sms_form', 'UserMailController@smsForm');
    Route::post('/send_sms', 'UserMailController@sendSMS');


    //site settings

    Route::get('/site_settings', 'SiteSettingsController@index');
    Route::post('/update_site_settings', 'SiteSettingsController@update');





    // logout 
    Route::get('logout', 'AuthController@logout')->name('logout');
});
