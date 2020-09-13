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


Route::post('/users', 'UserController@store');
Route::get('/users/{user_id}', 'UserController@getUserById');

Route::get('/applications/client/{app_id}', 'ApplicationController@getApplicationByAppId');
Route::post('/applications/client/{app_id}/check-secret', 'ApplicationController@checkSecret');


Route::group(['middleware' => 'checkAuth'], function () {
    Route::get('/applications/status/approve', 'ApplicationController@indexApprove');
    Route::get('/applications/status/pending', 'ApplicationController@indexPending');
    Route::get('/applications/status/reject', 'ApplicationController@indexReject');

    Route::get('/my-applications', 'ApplicationController@indexMe');

    Route::post('/applications', 'ApplicationController@store');
    Route::get('/applications/{app_id}', 'ApplicationController@getApplicationById');
    Route::delete('/applications/{id}', 'ApplicationController@destroy');

    Route::group(['middleware' => 'handleputformdata'], function () {
        Route::put('/applications/{id}', 'ApplicationController@update');
        Route::put('/applications/approve-reject/{id}', 'ApplicationController@updateStatusById');
    });
});
