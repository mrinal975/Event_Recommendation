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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('event','API\EventController');
Route::apiResource('Profile','API\ProfileController');
Route::get('interest/{id}', 'API\ProfileController@interstShow');
Route::post('personalInterest', 'API\ProfileController@interstStore');
Route::put('InterestUpdate/{id}', 'API\ProfileController@interstUpdate');