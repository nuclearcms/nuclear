<?php

Route::group([
    'prefix' => 'tags',
    'middleware' => 'can:ACCESS_TAGS'
], function ()
{

    Route::resource('/', 'TagsController', ['except' => ['show', 'edit', 'update'], 'names' => [
        'index'   => 'reactor.tags.index',
        'create'  => 'reactor.tags.create',
        'store'   => 'reactor.tags.store',
        'destroy' => 'reactor.tags.destroy',
    ]]);

});