<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Event Route
Route::apiResource('event','API\EventController');
Route::apiResource('Profile','API\ProfileController');
Route::get('interest/{id}', 'API\ProfileController@interestShow');
Route::post('personalInterest', 'API\ProfileController@interestStore');
Route::put('InterestUpdate/{id}', 'API\ProfileController@interestUpdate');
Route::get('follow/{id}', 'API\FriendController@followOrNot');
Route::get('followStaus/{id}', 'API\FriendController@followStaus');

Route::get('insterestupdate/{id}', 'API\InterestedOnEventController@insterestupdate');
Route::get('goingupdate/{id}', 'API\InterestedOnEventController@goingupdate');
Route::get('totalGoing', 'API\InterestedOnEventController@totalgoing');
Route::get('totalInterested', 'API\InterestedOnEventController@totalinterested');
Route::get('search/{id}', 'API\SearchController@search');


// Schedule Route
Route::apiResource('schedule','API\SchedulerController');

//DailySchedule Route
Route::get('dailyEvent/', 'API\DailyScheduleController@DailyEvent');
Route::get('dailySchedule/', 'API\DailyScheduleController@DailySchedulet');

//followers AND following Route
Route::get('following/{id}', 'API\ProfileController@following');
Route::get('followers/{id}', 'API\ProfileController@followers');