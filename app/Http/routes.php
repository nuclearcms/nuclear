<?php

Route::get('locale/{locale}', [
    'as' => 'locale.set',
    'uses' => 'LocaleController@setLocale'
]);