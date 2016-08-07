<?php

Route::get('install/complete', [
    'as' => 'install-complete',
    'uses' => 'InstallerController@getComplete',
    'middleware' => ['set-theme:' . config('themes.active_install')]
]);