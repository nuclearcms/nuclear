<?php

Route::group([
    'prefix' => 'permissions',
    'middleware' => 'can:ACCESS_PERMISSIONS'
], function ()
{
    Route::resource('/', 'PermissionsController', ['except' => 'show', 'names' => [
        'index'   => 'reactor.permissions.index',
        'create'  => 'reactor.permissions.create',
        'store'   => 'reactor.permissions.store',
        'edit'    => 'reactor.permissions.edit',
        'update'  => 'reactor.permissions.update',
        'destroy' => 'reactor.permissions.destroy',
    ]]);

    Route::get('search', [
        'uses' => 'PermissionsController@search',
        'as'   => 'reactor.permissions.search']);

});