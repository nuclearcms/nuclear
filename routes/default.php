<?php

Route::group(['middleware' => ['locale', 'track']], function ()
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