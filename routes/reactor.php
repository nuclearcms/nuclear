<?php

Route::group([
    'prefix' => config('app.reactor_prefix'),
    'middleware' => ['set-theme:' . config('themes.active_reactor')]
], function ()
{

    // Authentication and password resets
    require_once 'reactor/auth.php';

    // Authenticated reactor
    Route::group(['middleware' => ['auth', 'can:ACCESS_REACTOR']], function ()
    {
        require_once 'reactor/dashboard.php';
    });

});