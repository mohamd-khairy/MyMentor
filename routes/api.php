<?php

use Illuminate\Http\Request;

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

Route::group([

    'middleware' => [ 'CheckToken' , 'api' ],
    'prefix' => 'v1'

], function () {

    Route::post('auth/logout', 'Api\AuthController@logout');
    Route::post('auth/refresh', 'Api\AuthController@refresh');
    Route::post('auth/me', 'Api\AuthController@me');

    /** route */
    Route::resource('days' , 'WeekDayController');
    Route::resource('language' , 'LanguageController');
    Route::resource('category' , 'CategoryController');
    Route::resource('education' , 'EducationController');
    Route::resource('experience' , 'ExperienceController');
    Route::resource('job' , 'JobDetailsController');
    Route::resource('payment' , 'PaymentController');
    Route::resource('profile' , 'ProfileController');
    Route::resource('rate' , 'RateController');
    Route::resource('session' , 'SessionController');
    Route::resource('skill' , 'SkillController');
    Route::resource('topics' , 'TopicsController');
    Route::resource('user' , 'UserController');

});

Route::group([
    
    'middleware' => 'api',
    'namespace' => 'Api',
    'prefix' => 'v1'

], function () {

    Route::post('auth/login', 'AuthController@login')->middleware('checkVerify');
    Route::post('auth/register', 'AuthController@register');
    Route::get('auth/verify', 'AuthController@verify');
    Route::post('auth/forget/password', 'AuthController@forgetPassword');
    Route::post('auth/reset/password', 'AuthController@resetPassword');

});