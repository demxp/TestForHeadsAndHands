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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/auth', 'ApiV1\UsersController@AuthUser');
Route::get('/weather', 'ApiV1\TownsController@GetAllWeather');

Route::group(['prefix' => 'api/v1', 'namespace' => 'ApiV1'], function(){
	Route::resource('/users', 'UsersController');
	Route::resource('/towns', 'TownsController');	
});

Route::group(['prefix' => 'adminpanel', 'namespace' => 'Admin'], function(){
	Route::get('/', 'DashboardController@index'); 
});