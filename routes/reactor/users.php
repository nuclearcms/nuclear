<?php

Route::group(['middleware' => 'can:ACCESS_USERS'], function ()
{

    Route::resource('users', 'UsersController', ['except' => ['show'], 'names' => [
        'index'   => 'reactor.users.index',
        'create'   => 'reactor.users.create',
        'store'   => 'reactor.users.store',
        'edit'    => 'reactor.users.edit',
        'update'  => 'reactor.users.update',
        'destroy' => 'reactor.users.destroy',
    ]]);

    Route::get('users/search', [
        'uses' => 'UsersController@search',
        'as'   => 'reactor.users.search']);

    Route::delete('users/destroy/bulk', [
        'uses' => 'UsersController@bulkDestroy',
        'as'   => 'reactor.users.destroy.bulk']);

    Route::get('users/{id}/password', [
        'uses' => 'UsersController@password',
        'as'   => 'reactor.users.password']);
    Route::put('users/{id}/password', [
        'uses' => 'UsersController@updatePassword',
        'as'   => 'reactor.users.password.post']);

    Route::get('users/{id}/roles', [
        'uses' => 'UsersController@roles',
        'as'   => 'reactor.users.roles']);
    Route::put('users/{id}/roles', [
        'uses' => 'UsersController@associateRole',
        'as'   => 'reactor.users.roles.associate']);
    Route::delete('users/{id}/roles', [
        'uses' => 'UsersController@dissociateRole',
        'as'   => 'reactor.users.roles.dissociate']);

    Route::get('users/{id}/permissions', [
        'uses' => 'UsersController@permissions',
        'as'   => 'reactor.users.permissions']);
    Route::put('users/{id}/permissions', [
        'uses' => 'UsersController@addPermission',
        'as'   => 'reactor.users.permissions.add']);
    Route::delete('users/{id}/permissions', [
        'uses' => 'UsersController@revokePermission',
        'as'   => 'reactor.users.permissions.revoke']);

    Route::get('users/{id}/history', [
        'uses' => 'UsersController@history',
        'as'   => 'reactor.users.history']);

});