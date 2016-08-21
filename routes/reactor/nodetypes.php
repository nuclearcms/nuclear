<?php

Route::group(['middleware' => 'can:ACCESS_NODETYPES'], function ()
{

    Route::resource('nodetypes', 'NodeTypesController', ['except' => ['show'], 'names' => [
        'index'   => 'reactor.nodetypes.index',
        'create'   => 'reactor.nodetypes.create',
        'store'   => 'reactor.nodetypes.store',
        'edit'    => 'reactor.nodetypes.edit',
        'update'  => 'reactor.nodetypes.update',
        'destroy' => 'reactor.nodetypes.destroy',
    ]]);

    Route::get('nodetypes/search', [
        'uses' => 'NodeTypesController@search',
        'as'   => 'reactor.nodetypes.search']);

    Route::post('nodetypes/search/type/nodes', [
        'uses' => 'NodeTypesController@searchTypeNodes',
        'as'   => 'reactor.nodetypes.search.type.nodes']);

    Route::delete('nodetypes/destroy/bulk', [
        'uses' => 'NodeTypesController@bulkDestroy',
        'as'   => 'reactor.nodetypes.destroy.bulk']);

    Route::get('nodetypes/{id}/fields', [
        'uses' => 'NodeTypesController@fields',
        'as'   => 'reactor.nodetypes.fields']);

    Route::get('nodetypes/{id}/nodes', [
        'uses' => 'NodeTypesController@nodes',
        'as'   => 'reactor.nodetypes.nodes']);

    Route::resource('nodefields', 'NodeFieldsController', ['except' => ['index', 'show', 'create', 'store'], 'names' => [
        'store'   => 'reactor.nodefields.store',
        'edit'    => 'reactor.nodefields.edit',
        'update'  => 'reactor.nodefields.update',
        'destroy' => 'reactor.nodefields.destroy',
    ]]);

    Route::get('nodefields/create/{id}', [
        'uses' => 'NodeFieldsController@create',
        'as' => 'reactor.nodefields.create'
    ]);

    Route::post('nodefields/create/{id}', [
        'uses' => 'NodeFieldsController@store',
        'as' => 'reactor.nodefields.store'
    ]);

});