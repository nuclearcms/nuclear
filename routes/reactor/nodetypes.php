<?php

Route::group(['middleware' => 'can:ACCESS_NODETYPES'], function ()
{

    Route::resource('nodetypes', 'NodeTypesController', ['except' => ['show'], 'names' => [
        'index'   => 'reactor.nodetypes.index',
        'create'   => 'reactor.nodetypes.create',
        'store'   => 'reactor.nodetypes.store',
        'edit'    => 'reactor.nodetypes.edit',
        'update'  => 'reactor.nodetypes.update',
        'destroy' => 'reactor.nodetypes.destroy',
    ]]);

});