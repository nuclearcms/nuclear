<?php

Route::group(['prefix' => 'install'], function ()
{
    Route::get('welcome', [
        'as' => 'install-welcome',
        'uses' => 'InstallerController@getWelcome'
    ]);
});

