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

    'middleware' => ['api' , 'CheckToken'],
    'prefix' => 'v1'

], function () {

    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/refresh', 'AuthController@refresh');
    Route::post('auth/me', 'AuthController@me');

    /** route */
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

    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/register', 'AuthController@register');

});