<?php

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


Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('{path}', 'HomeController@index')
->where('path','([A-z\d-\/_.]+)?');

// Route::get('/vue/{vue_capture?}', function () {
//  return view('vue.index');
// })->where('vue_capture', '[\/\w\.-]*');

