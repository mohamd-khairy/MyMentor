<?php

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

Route::group([

    'middleware' => ['CheckToken', 'api'],
    'prefix' => 'v1'

], function () {

    Route::post('auth/logout', 'Api\AuthController@logout');
    Route::post('auth/refresh', 'Api\AuthController@refresh');
    Route::post('auth/me', 'Api\AuthController@me');

    /** route */
    Route::resource('days', 'WeekDayController'); // done
    Route::resource('language', 'LanguageController'); // done
    Route::resource('category', 'CategoryController'); // done
    Route::resource('education', 'EducationController'); // done
    Route::resource('experience', 'ExperienceController'); // done
    Route::resource('class', 'ClassDetailsController'); // done
    Route::resource('payment', 'PaymentController'); // done check table database
    Route::resource('profile', 'ProfileController'); // done
    Route::resource('rate', 'RateController'); // done
    Route::resource('session', 'SessionController'); // done
    Route::resource('skill', 'SkillController'); // done
    Route::resource('topic', 'TopicsController'); // done
    Route::resource('user', 'UserController'); // done
    Route::resource('chat', 'ChatController'); // done
    Route::resource('message', 'MessageController'); // done
    Route::resource('job', 'JobDetailsController'); // done
    Route::get('notification', 'NotificationController@index'); // done
    Route::get('notification/read/{user_id}', 'NotificationController@readed'); // done

    Route::post('skill/{id}', 'SkillController@update_skill'); // done

    Route::post('profile', 'ProfileController@update_profile'); // done
    Route::get('mentor-profile/{id}', 'ProfileController@show_mentor_profile'); // done

    Route::get('search', 'TopicsController@search'); // done

    // Route::get('unReadMessages' , 'MessageController@get_un_read_messages'); // done

    Route::post('accept/{session_id}', 'SessionController@acceptOrReject')->middleware('PermissionFor:mentor'); //done
    Route::get('schedule_session', 'SessionController@schedule_sessions'); // done
    Route::get('codeReview_session', 'SessionController@get_codeReview_session'); // done


    Route::get('zoom/create', 'CategoryController@create_meeting');
});

Route::group([

    'middleware' => 'api',
    'namespace' => 'Api',
    'prefix' => 'v1'

], function () {

    Route::get('most_popular_mentor', 'HomePageController@most_popular_mentor'); //done

    Route::post('auth/social_login', 'AuthController@social_login');
    Route::post('auth/login', 'AuthController@login')->middleware('checkVerify');
    Route::post('auth/register', 'AuthController@register');
    Route::get('auth/verify', 'AuthController@verify');
    Route::post('auth/forget/password', 'AuthController@forgetPassword');
    Route::post('auth/reset/password', 'AuthController@resetPassword');
});