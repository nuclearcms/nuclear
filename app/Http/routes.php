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

Route::get('/', function ()
{
    return view('welcome');
});

/**
 * Reactor routes
 */
Route::group(['prefix' => 'reactor'], function ()
{
    // Dashboard
    Route::get('/', 'DashboardController@index');

    // Authentication
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    // Password Reset
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

    // Users
    Route::resource('users', 'UsersController', ['except' => 'show']);
    Route::get('users/search', 'UsersController@search');
    Route::get('users/{id}/password', 'UsersController@password');
    Route::put('users/{id}/password', 'UsersController@updatePassword');
    Route::get('users/{id}/roles', 'UsersController@roles');
    Route::put('users/{id}/roles', 'UsersController@updateRoles');
    Route::get('users/{id}/groups', 'UsersController@groups');
    Route::put('users/{id}/groups', 'UsersController@updateGroups');
    Route::get('users/{id}/history', 'UsersController@history');

    // Groups

    // Roles
    Route::resource('roles', 'RolesController', ['except' => 'show']);
    Route::get('roles/search', 'RolesController@search');

});
