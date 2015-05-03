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

Route::get('/', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/matches', 'MatchesController@index');
Route::get('/match/{id}', 'MatchesController@show');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function()
{
    Route::get('/matches', 'MatchesController@todo');
    Route::get('/matches/new', 'MatchesController@create');
    Route::post('/matches/new', 'MatchesController@save');
    Route::get('/matches/form', 'Admin\MatchesController@formData');
});