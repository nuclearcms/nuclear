<?php

Route::group([
    'prefix' => 'install',
    'middleware' => ['set-theme:' . config('themes.active_install')]
], function ()
{

    Route::get('welcome', [
        'as' => 'install-welcome',
        'uses' => 'InstallerController@getWelcome'
    ]);

    Route::post('welcome', [
        'as' => 'install-welcome-post',
        'uses' => 'InstallerController@postWelcome'
    ]);

    Route::get('database', [
        'as' => 'install-database',
        'uses' => 'InstallerController@getDatabase'
    ]);

    Route::post('database', [
        'as' => 'install-database-post',
        'uses' => 'InstallerController@postDatabase'
    ]);

    Route::get('user', [
        'as' => 'install-user',
        'uses' => 'InstallerController@getUser'
    ]);

    Route::post('user', [
        'as' => 'install-user-post',
        'uses' => 'InstallerController@postUser'
    ]);

    Route::get('site', [
        'as' => 'install-site',
        'uses' => 'InstallerController@getSite'
    ]);

});

