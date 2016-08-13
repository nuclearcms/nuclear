<?php

Route::group(['middleware' => 'can:ACCESS_ROLES'], function ()
{

    Route::resource('roles', 'RolesController', ['except' => 'show', 'names' => [
        'index'   => 'reactor.roles.index',
        'create'  => 'reactor.roles.create',
        'store'   => 'reactor.roles.store',
        'edit'    => 'reactor.roles.edit',
        'update'  => 'reactor.roles.update',
        'destroy' => 'reactor.roles.destroy',
    ]]);

    Route::get('roles/search', [
        'uses' => 'RolesController@search',
        'as'   => 'reactor.roles.search']);

    Route::delete('roles/destroy/bulk', [
        'uses' => 'RolesController@bulkDestroy',
        'as'   => 'reactor.roles.destroy.bulk']);

    Route::get('roles/{id}/permissions', [
        'uses' => 'RolesController@permissions',
        'as'   => 'reactor.roles.permissions']);
    Route::put('roles/{id}/permissions', [
        'uses' => 'RolesController@addPermission',
        'as'   => 'reactor.roles.permission.add']);
    Route::delete('roles/{id}/permissions', [
        'uses' => 'RolesController@revokePermission',
        'as'   => 'reactor.roles.permission.revoke']);

    Route::get('roles/{id}/users', [
        'uses' => 'RolesController@users',
        'as'   => 'reactor.roles.users']);
    Route::put('roles/{id}/users', [
        'uses' => 'RolesController@addUser',
        'as'   => 'reactor.roles.user.add']);
    Route::delete('roles/{id}/users', [
        'uses' => 'RolesController@revokeUser',
        'as'   => 'reactor.roles.user.revoke']);

});