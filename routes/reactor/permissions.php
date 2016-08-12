<?php

Route::group(['middleware' => 'can:ACCESS_PERMISSIONS'], function ()
{
    Route::resource('permissions', 'PermissionsController', ['except' => 'show', 'names' => [
        'index'   => 'reactor.permissions.index',
        'create'  => 'reactor.permissions.create',
        'store'   => 'reactor.permissions.store',
        'edit'    => 'reactor.permissions.edit',
        'update'  => 'reactor.permissions.update',
        'destroy' => 'reactor.permissions.destroy',
    ]]);

    Route::get('permissions/search', [
        'uses' => 'PermissionsController@search',
        'as'   => 'reactor.permissions.search']);

    Route::delete('permissions/destroy/bulk', [
        'uses' => 'PermissionsController@bulkDestroy',
        'as'   => 'reactor.permissions.destroy.bulk']);

});