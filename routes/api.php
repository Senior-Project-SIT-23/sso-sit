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

Route::get('/applications/{app_id}', 'ApplicationController@getApplicationById');
Route::post('/applications/{app_id}/check-secret', 'ApplicationController@checkSecret');

Route::group(['middleware' => 'handleputformdata'], function () {
    Route::group(['middleware' => 'checkAuth'], function () {
        Route::post('/applications', 'ApplicationController@store');
        Route::put('/applications/{id}', 'ApplicationController@update');
        Route::put('/applications/approve-reject/{id}', 'ApplicationController@updateStatusById');
        Route::delete('/applications/{id}', 'ApplicationController@destroy');
    });
});
