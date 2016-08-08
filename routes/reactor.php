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
        require_once 'reactor/documents.php';
        require_once 'reactor/mailings.php';
        require_once 'reactor/maintenance.php';
        require_once 'reactor/nodes.php';
        require_once 'reactor/nodetypes.php';
        require_once 'reactor/permissions.php';
        require_once 'reactor/profile.php';
        require_once 'reactor/roles.php';
        require_once 'reactor/tags.php';
        require_once 'reactor/update.php';
        require_once 'reactor/users.php';
    });

});