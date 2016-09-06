<?php

// Mailing preview
Route::get('mailings/{mailing}', [
    'as' => 'reactor.mailings.preview',
    'uses' => 'MailingsController@preview',
    'middleware' => ['set-theme:' . config('themes.active_mailings')]
]);

// Installation complete
Route::get('install/complete', [
    'as' => 'install-complete',
    'uses' => 'InstallerController@getComplete',
    'middleware' => ['set-theme:' . config('themes.active_install')]
]);