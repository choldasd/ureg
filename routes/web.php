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

Auth::routes();

Route::get('/street', 'Auth\RegisterController@getStreetData')->name('street');
Route::get('/zipcode', 'Auth\RegisterController@getZipcodeData')->name('zipcode');

Route::group(['middleware' => ['prevent-back-history','auth']],function(){
    Route::get('/home', 'HomeController@index')->name('home');
});

