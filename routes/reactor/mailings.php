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


    Route::group(['prefix' => 'mailings'], function ()
    {
        Route::get('search', [
            'uses' => 'MailingsController@search',
            'as'   => 'reactor.mailings.search']);

        Route::delete('destroy/bulk', [
            'uses' => 'MailingsController@bulkDestroy',
            'as'   => 'reactor.mailings.destroy.bulk']);

        Route::get('{id}/transform', [
            'uses' => 'MailingsController@transform',
            'as'   => 'reactor.mailings.transform']);
        Route::put('{id}/transform', [
            'uses' => 'MailingsController@transformPut',
            'as'   => 'reactor.mailings.transform.put']);

        Route::get('{id}/lists', [
            'uses' => 'MailingsController@lists',
            'as'   => 'reactor.mailings.lists']);
        Route::put('{id}/lists', [
            'uses' => 'MailingsController@associateList',
            'as'   => 'reactor.mailings.lists.associate']);
        Route::delete('{id}/lists', [
            'uses' => 'MailingsController@dissociateList',
            'as'   => 'reactor.mailings.lists.dissociate']);


        require 'mailing_lists.php';
        require 'subscribers.php';
    });

});