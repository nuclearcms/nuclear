<?php

Route::group(['middleware' => ['track']], function ()
{

    Route::get('/', [
        'as'   => 'site.home',
        'uses' => '\Extension\Site\Http\SiteController@getHome']);

    Route::get('{node}', [
        'as'   => 'site.page',
        'uses' => '\Extension\Site\Http\SiteController@getPage']);

});