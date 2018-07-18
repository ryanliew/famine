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

Route::get("/input", function() {
	return view('enter');
});

Route::get("/teams", "TeamController@index");
Route::post("/teams/reduce", "TeamController@reduce");
Route::get("/team/{team}", "TeamController@get");
Route::post("/team/{team}", "TeamController@update");

Route::get("phpinfo", function() {
	phpinfo();
});
