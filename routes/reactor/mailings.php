<?php

Route::group(['middleware' => 'can:ACCESS_MAILINGS'], function ()
{

    Route::resource('mailings', 'MailingsController', ['except' => 'show', 'names' => [
        'index'   => 'reactor.mailings.index',
        'create'  => 'reactor.mailings.create',
        'store'   => 'reactor.mailings.store',
        'edit'    => 'reactor.mailings.edit',
        'update'  => 'reactor.mailings.update',
        'destroy' => 'reactor.mailings.destroy',
    ]]);

    Route::get('mailings/lists', [
        'uses' => 'MailingsController@lists',
        'as' => 'reactor.mailings.lists']);

});