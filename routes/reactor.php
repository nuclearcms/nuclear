<?php

Route::group([
    'prefix' => config('app.reactor_prefix'),
    'middleware' => ['set-theme:' . config('themes.active_reactor')]
], function ()
{

    require 'reactor/auth.php';

});