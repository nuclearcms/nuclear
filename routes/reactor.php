<?php

Route::group([
    'prefix' => config('app.reactor_prefix'),
    'middleware' => ['set-theme:' . config('themes.active_reactor')]
], function ()
{

    require_once 'reactor/auth.php';

    // General reactor group
    Route::group(['middleware' => ['auth', 'guard:ACCESS_REACTOR']], function ()
    {
        require_once 'reactor/dashboard.php';
    });

});