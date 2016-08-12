<?php

Route::group(['middleware' => 'can:ACCESS_TAGS'], function ()
{

    Route::resource('tags', 'TagsController', ['except' => ['show'], 'names' => [
        'index'   => 'reactor.tags.index',
        'create'  => 'reactor.tags.create',
        'store'   => 'reactor.tags.store',
        'edit'    => 'reactor.tags.edit',
        'update'  => 'reactor.tags.update',
        'destroy' => 'reactor.tags.destroy',
    ]]);

});