<?php

Route::group([
    'prefix' => 'nodes',
    'middleware' => 'can:ACCESS_NODES'
], function ()
{
    Route::get('/', [
        'uses' => 'NodesController@index',
        'as' => 'reactor.nodes.index'
    ]);

    Route::get('create/{id?}', [
        'uses' => 'NodesController@create',
        'as'   => 'reactor.nodes.create']);
    Route::post('create/{id?}', [
        'uses' => 'NodesController@store',
        'as'   => 'reactor.nodes.store']);

    Route::get('{id}/edit/{source?}', [
        'uses' => 'NodesController@edit',
        'as' => 'reactor.nodes.edit'
    ]);
    Route::put('{id}/edit/{source}', [
        'uses' => 'NodesController@update',
        'as' => 'reactor.nodes.update'
    ]);

    Route::get('search', [
        'uses' => 'NodesController@search',
        'as'   => 'reactor.nodes.search']);

    Route::post('locale', [
        'uses' => 'NodesController@changeTreeLocale',
        'as'   => 'reactor.nodes.locale'
    ]);

});