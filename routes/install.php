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

    Route::get('requirements', [
        'as' => 'install-requirements',
        'uses' => 'InstallerController@getRequirements'
    ]);

});

