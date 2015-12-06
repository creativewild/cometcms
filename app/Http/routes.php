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

/**
 * TODO: Change this terrible route shorthand to something more readable
 */
Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'Admin\DashboardController@index');

    /**
     * Games
     */
    Route::get('/games', 'Admin\GamesController@index');
    Route::get('/games/new', 'Admin\GamesController@create');
    Route::post('/games/new', 'Admin\GamesController@save');
    Route::get('/games/edit/{id}', 'Admin\GamesController@edit');
    Route::post('/games/edit/{id}', 'Admin\GamesController@update');
    Route::get('/games/delete/{id}', 'Admin\GamesController@delete');

    Route::get('/games/trash', 'Admin\GamesController@trash');
    Route::get('/games/restore/{id}', 'Admin\GamesController@restore');
    Route::get('/games/remove/{id}', 'Admin\GamesController@remove');

    /**
     * Users
     */
    Route::get('/users', 'Admin\UsersController@index');
    Route::get('/users/new', 'Admin\UsersController@create');
    Route::post('/users/new', 'Admin\UsersController@save');
    Route::get('/users/edit/{id}', 'Admin\UsersController@edit');
    Route::post('/users/edit/{id}', 'Admin\UsersController@update');
    Route::get('/users/delete/{id}', 'Admin\UsersController@delete');
    Route::group(['prefix' => 'api'], function () {
        Route::get('/users/', 'Admin\UsersController@searchUsers');
    });

    Route::get('/users/trash', 'Admin\UsersController@trash');
    Route::get('/users/restore/{id}', 'Admin\UsersController@restore');
    Route::get('/users/remove/{id}', 'Admin\UsersController@remove');

    /**
     * Opponents
     */
    Route::get('/opponents', 'Admin\OpponentsController@index');
    Route::get('/opponents/new', 'Admin\OpponentsController@create');
    Route::post('/opponents/new', 'Admin\OpponentsController@save');
    Route::get('/opponents/edit/{id}', 'Admin\OpponentsController@edit');
    Route::post('/opponents/edit/{id}', 'Admin\OpponentsController@update');
    Route::get('/opponents/delete/{id}', 'Admin\OpponentsController@delete');
    Route::get('/opponents/delete-image/{id}', 'Admin\OpponentsController@deleteImage');

    Route::get('/opponents/trash', 'Admin\OpponentsController@trash');
    Route::get('/opponents/restore/{id}', 'Admin\OpponentsController@restore');
    Route::get('/opponents/remove/{id}', 'Admin\OpponentsController@remove');

    /**
     * Posts
     */
    Route::get('/posts', 'Admin\PostsController@index');
    Route::get('/posts/new', 'Admin\PostsController@create');
    Route::post('/posts/new', 'Admin\PostsController@save');
    Route::get('/posts/edit/{id}', 'Admin\PostsController@edit');
    Route::post('/posts/edit/{id}', 'Admin\PostsController@update');
    Route::get('/posts/delete/{id}', 'Admin\PostsController@delete');

    Route::get('/posts/trash', 'Admin\PostsController@trash');
    Route::get('/posts/restore/{id}', 'Admin\PostsController@restore');
    Route::get('/posts/remove/{id}', 'Admin\PostsController@remove');

    /**
     * Teams
     */
    Route::get('/teams', 'Admin\TeamsController@index');
    Route::post('/teams', 'Admin\TeamsController@save');
    Route::put('/teams/{id}', 'Admin\TeamsController@update');
    Route::get('/teams/new', 'Admin\TeamsController@create');
    Route::get('/teams/edit/{id}', 'Admin\TeamsController@edit');
    Route::get('/teams/delete/{id}', 'Admin\TeamsController@delete');
    Route::group(['prefix' => 'api'], function () {
        Route::get('/teams/{id}', 'Admin\TeamsController@get');
        Route::get('/teams/history/{id}', 'Admin\TeamsController@getHistory');
    });

    /**
     * Matches
     */
    Route::group(['prefix' => 'matches'], function () {
        Route::get('/', 'Admin\MatchesController@index');
        Route::get('/new', 'Admin\MatchesController@create');
        Route::post('/new', 'Admin\MatchesController@save');
        Route::get('/edit/{id}', 'Admin\MatchesController@edit');
        Route::post('/edit/{id}', 'Admin\MatchesController@update');
        Route::get('/delete/{id}', 'Admin\MatchesController@delete');
        Route::get('/api/edit/{id}', 'Admin\MatchesController@getMatchJson');
        Route::get('/api/meta', 'Admin\MatchesController@getMetaJson');
    });

    /**
     * User roles
     */
    Route::get('/roles', 'Admin\RolesController@index');
    Route::get('/roles/new', 'Admin\RolesController@create');
    Route::post('/roles/new', 'Admin\RolesController@save');
    Route::get('/roles/edit/{id}', 'Admin\RolesController@edit');
    Route::post('/roles/edit/{id}', 'Admin\RolesController@update');
    Route::get('/roles/delete/{id}', 'Admin\RolesController@delete');
});

Entrust::routeNeedsRole('admin*', 'admin', Redirect::to('/'));

Entrust::routeNeedsPermission('admin/matches/new', 'create-match');
Entrust::routeNeedsPermission('admin/matches/edit', 'edit-match');
Entrust::routeNeedsPermission('admin/matches/delete', 'delete-match');