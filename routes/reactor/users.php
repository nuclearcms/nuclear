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

});