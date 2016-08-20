<?php

Route::group(['middleware' => 'can:ACCESS_DOCUMENTS'], function ()
{

    Route::resource('documents', 'DocumentsController', ['except' => ['show', 'create'], 'names' => [
        'index'   => 'reactor.documents.index',
        'store'   => 'reactor.documents.store',
        'edit'    => 'reactor.documents.edit',
        'update'  => 'reactor.documents.update',
        'destroy' => 'reactor.documents.destroy',
    ]]);

    Route::get('documents/upload', [
        'uses' => 'DocumentsController@upload',
        'as'   => 'reactor.documents.upload']);

    Route::get('documents/embed', [
        'uses' => 'DocumentsController@embed',
        'as'   => 'reactor.documents.embed']);
    Route::post('documents/embed', [
        'uses' => 'DocumentsController@storeEmbedded',
        'as'   => 'reactor.documents.embed.store']);

    Route::get('documents/image/{id}', [
        'uses' => 'DocumentsController@image',
        'as'   => 'reactor.documents.image.edit']);
    Route::put('documents/image/{id}', [
        'uses' => 'DocumentsController@imageUpdate',
        'as'   => 'reactor.documents.image.update']);

    Route::get('documents/download/{id}', [
        'uses' => 'DocumentsController@download',
        'as'   => 'reactor.documents.download']);

    Route::get('documents/search', [
        'uses' => 'DocumentsController@search',
        'as'   => 'reactor.documents.search']);

    Route::delete('documents/destroy/bulk', [
        'uses' => 'DocumentsController@bulkDestroy',
        'as'   => 'reactor.documents.destroy.bulk']);

});