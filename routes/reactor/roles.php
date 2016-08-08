<?php

Route::group([
    'prefix' => 'roles',
    'middleware' => 'can:ACCESS_ROLES'
], function ()
{
    Route::resource('/', 'RolesController', ['except' => 'show', 'names' => [
        'index'   => 'reactor.roles.index',
        'create'  => 'reactor.roles.create',
        'store'   => 'reactor.roles.store',
        'edit'    => 'reactor.roles.edit',
        'update'  => 'reactor.roles.update',
        'destroy' => 'reactor.roles.destroy',
    ]]);
});