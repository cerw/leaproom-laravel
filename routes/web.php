<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('video', 'VideoController@index')
     ->name('video.index');

Route::post('video/store', 'VideoController@store')
     ->name('video.store');

Route::post('phones/store', 'PhonesController@store')
     ->name('phones.store');
