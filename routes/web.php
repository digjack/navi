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
    session('user_id', 'default');
    session('login_status', 0);
    return view('navi');
});

Route::get('list', "IndexController@list");
Route::put('site', "IndexController@save");
Route::delete('site', "IndexController@delete");

Route::get('user', "IndexController@userInfo");
Route::put('user', "IndexController@regist");
Route::post('user', "IndexController@login");
Route::post('logout', "IndexController@logout");

Route::get('sitegen', "IndexController@sitegen");




