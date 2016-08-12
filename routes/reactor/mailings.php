<?php

Route::group(['middleware' => 'can:ACCESS_MAILINGS'], function ()
{

    Route::get('mailings', [
        'uses' => 'MailingsController@index',
        'as' => 'reactor.mailings.index'
    ]);

    Route::get('lists', [
        'uses' => 'MailingsController@lists',
        'as' => 'reactor.mailings.lists'
    ]);

});