<?php

Route::group([
    'prefix' => 'documents',
    'middleware' => 'can:ACCESS_DOCUMENTS'
], function ()
{

    Route::resource('/', 'DocumentsController', ['except' => ['show', 'create'], 'names' => [
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

});