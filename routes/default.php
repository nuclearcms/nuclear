<?php

Route::group(['middleware' => 'locale'], function ()
{

    Route::get('/', [
        'as' => 'home',
        'uses' => '\Extension\Site\Http\SiteController@getHome'
    ]);

    Route::get('{node}', [
        'as' => 'page',
        'uses' => '\Extension\Site\Http\SiteController@getPage'
    ]);

});