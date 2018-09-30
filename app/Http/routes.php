<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/events', 'EventsController@index');

Route::get('/events/create', 'EventsController@create');

Route::get('/events/{id}', 'EventsController@show');

Route::get('/events/{id}/edit', 'EventsController@edit');

Route::put('/events/{id}', 'EventsController@update');

Route::delete('/events/{id}', 'EventsController@destroy');

Route::post('/events/store', 'EventsController@store');