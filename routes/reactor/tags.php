<?php

Route::group(['middleware' => 'can:ACCESS_TAGS'], function ()
{

    Route::resource('tags', 'TagsController', ['except' => ['show', 'edit', 'update'], 'names' => [
        'index'   => 'reactor.tags.index',
        'create'  => 'reactor.tags.create',
        'store'   => 'reactor.tags.store',
        'destroy' => 'reactor.tags.destroy',
    ]]);

    Route::get('tags/{id}/edit/{translation}', [
        'uses' => 'TagsController@edit',
        'as' => 'reactor.tags.edit'
    ]);
    Route::put('tags/{id}/edit/{translation}', [
        'uses' => 'TagsController@update',
        'as' => 'reactor.tags.update'
    ]);

    Route::get('tags/{id}/translate/{translation}', [
        'uses' => 'TagsController@createTranslation',
        'as'   => 'reactor.tags.translations.create']);
    Route::post('tags/{id}/translate', [
        'uses' => 'TagsController@storeTranslation',
        'as'   => 'reactor.tags.translations.store']);

    Route::get('tags/{id}/nodes/{translation}', [
        'uses' => 'TagsController@nodes',
        'as' => 'reactor.tags.nodes'
    ]);

    Route::get('tags/search', [
        'uses' => 'TagsController@search',
        'as'   => 'reactor.tags.search']);
    Route::post('tags/search', [
        'uses' => 'TagsController@searchJson',
        'as'   => 'reactor.tags.search.json']);

});