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

    Route::get('mailings/search', [
        'uses' => 'MailingsController@search',
        'as'   => 'reactor.mailings.search']);

    Route::delete('mailings/destroy/bulk', [
        'uses' => 'MailingsController@bulkDestroy',
        'as'   => 'reactor.mailings.destroy.bulk']);


    Route::group(['prefix' => 'mailings'], function ()
    {
        require 'mailing_lists.php';
        require 'mailing_subscribers.php';
    });

});