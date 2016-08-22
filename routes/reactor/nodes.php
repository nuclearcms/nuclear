<?php

Route::group([
    'prefix' => 'nodes',
    'middleware' => 'can:ACCESS_NODES'
], function ()
{
    Route::get('/', [
        'uses' => 'NodesController@index',
        'as' => 'reactor.nodes.index']);

    Route::get('search', [
        'uses' => 'NodesController@search',
        'as'   => 'reactor.nodes.search']);

    Route::get('create/{id?}', [
        'uses' => 'NodesController@create',
        'as'   => 'reactor.nodes.create']);
    Route::post('create/{id?}', [
        'uses' => 'NodesController@store',
        'as'   => 'reactor.nodes.store']);

    Route::get('{id}/edit/{source}', [
        'uses' => 'NodesController@edit',
        'as' => 'reactor.nodes.edit']);
    Route::put('{id}/edit/{source}', [
        'uses' => 'NodesController@update',
        'as' => 'reactor.nodes.update']);

    Route::delete('{id}', [
        'uses' => 'NodesController@destroy',
        'as'   => 'reactor.nodes.destroy']);
    Route::delete('destroy/bulk', [
        'uses' => 'NodesController@bulkDestroy',
        'as'   => 'reactor.nodes.destroy.bulk']);

    Route::put('{id}/publish', [
        'uses' => 'NodesController@publish',
        'as' => 'reactor.nodes.publish']);
    Route::put('{id}/unpublish', [
        'uses' => 'NodesController@unpublish',
        'as' => 'reactor.nodes.unpublish']);

    Route::put('{id}/lock', [
        'uses' => 'NodesController@lock',
        'as' => 'reactor.nodes.lock']);
    Route::put('{id}/unlock', [
        'uses' => 'NodesController@unlock',
        'as' => 'reactor.nodes.unlock']);

    Route::put('{id}/show', [
        'uses' => 'NodesController@show',
        'as' => 'reactor.nodes.show']);
    Route::put('{id}/hide', [
        'uses' => 'NodesController@hide',
        'as' => 'reactor.nodes.hide']);

    Route::get('{id}/translate/{source}', [
        'uses' => 'NodesController@createTranslation',
        'as'   => 'reactor.nodes.translation.create']);
    Route::post('{id}/translate', [
        'uses' => 'NodesController@storeTranslation',
        'as'   => 'reactor.nodes.translation.store']);
    Route::delete('translation/{id}', [
        'uses' => 'NodesController@destroyTranslation',
        'as'   => 'reactor.nodes.translation.destroy']);

    Route::post('locale', [
        'uses' => 'NodesController@changeTreeLocale',
        'as'   => 'reactor.nodes.locale']);

});