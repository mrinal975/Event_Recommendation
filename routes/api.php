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
Route::get('interest/{id}', 'API\ProfileController@interestShow');
Route::post('personalInterest', 'API\ProfileController@interestStore');
Route::put('InterestUpdate/{id}', 'API\ProfileController@interestUpdate');
Route::get('follow/{id}', 'API\FriendController@followOrNot');
Route::get('followStaus/{id}', 'API\FriendController@followStaus');

Route::get('insterestupdate/{id}', 'API\InterestedOnEventController@insterestupdate');
Route::get('goingupdate/{id}', 'API\InterestedOnEventController@goingupdate');
Route::get('search/{id}', 'API\SearchController@search');