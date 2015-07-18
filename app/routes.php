<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    dd(app()->view);
});

Route::get('/enable-override', function () {
    Session::put('override', 'example');

    return Redirect::back();
});

Route::get('/disable-override', function () {
    Session::forget('override');

    return Redirect::back();
});

Route::get('/test', function () {
    return View::make('hello');
});

Route::get('/test2', function () {
    return View::make('dontoverride');
});
