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

});