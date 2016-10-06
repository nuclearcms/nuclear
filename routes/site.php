<?php

Route::group(['middleware' => ['track']], function ()
{

    Route::get('/', [
        'as'   => 'site.home',
        'uses' => '\Extension\Site\Http\SiteController@getHome']);

    // The parameter-bound routes should be
    // before the default slug route at the bottom
    Route::get('{search}', [
        'as' => 'site.search',
        'uses' => '\Extension\Site\Http\SiteController@getSearch']);

    Route::get('{tags}/{slug}', [
        'as' => 'site.tag',
        'uses' => '\Extension\Site\Http\SiteController@getTag']);

    Route::get('{slug}', [
        'as'   => 'site.page',
        'uses' => '\Extension\Site\Http\SiteController@getPage']);

});