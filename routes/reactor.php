<?php

Route::group([
    'prefix' => config('app.reactor_prefix'),
    'middleware' => ['set-theme:' . config('themes.active_reactor')]
], function ()
{

    // Authentication and password resets
    require 'reactor/auth.php';

    // Authenticated reactor
    Route::group(['middleware' => ['auth', 'can:ACCESS_REACTOR']], function ()
    {
        require 'reactor/dashboard.php';
        require 'reactor/documents.php';
        require 'reactor/mailings.php';
        require 'reactor/maintenance.php';
        require 'reactor/nodes.php';
        require 'reactor/nodetypes.php';
        require 'reactor/permissions.php';
        require 'reactor/profile.php';
        require 'reactor/roles.php';
        require 'reactor/tags.php';
        require 'reactor/update.php';
        require 'reactor/users.php';
    });

});