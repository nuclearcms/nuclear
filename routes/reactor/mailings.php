<?php

Route::group([
    'prefix' => 'mailings',
    'middleware' => 'can:ACCESS_MAILINGS'
], function ()
{
    Route::resource('/', 'MailingsController', ['except' => ['show'], 'names' => [
        'index'   => 'reactor.mailings.index',
        'create'   => 'reactor.mailings.create',
        'store'   => 'reactor.mailings.store',
        'edit'    => 'reactor.mailings.edit',
        'update'  => 'reactor.mailings.update',
        'destroy' => 'reactor.mailings.destroy',
    ]]);

    Route::get('lists', [
        'uses' => 'NodesController@lists',
        'as' => 'reactor.mailings.lists'
    ]);

});