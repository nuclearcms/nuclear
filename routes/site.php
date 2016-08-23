<?php

Route::get('/', [
    'as' => 'site.home',
    'uses' => 'SiteController@getHome'
]);
