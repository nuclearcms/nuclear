<?php

Route::get('locale/{locale}', [
    'as'   => 'locale.set',
    'uses' => 'LocaleController@setLocale'
]);

Route::get('locale/{locale}/home', [
    'as'   => 'locale.set.home',
    'uses' => 'LocaleController@setLocaleAndRedirectHome'
]);