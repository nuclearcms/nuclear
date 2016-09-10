<?php

Route::group([
    'prefix' => 'update',
    'middleware' => 'can:ACCESS_UPDATE'
], function ()
{

    Route::get('/', [
        'uses' => 'UpdateController@index',
        'as' => 'reactor.update.index']);

    Route::get('start', [
        'uses' => 'UpdateController@start',
        'as' => 'reactor.update.start']);

    Route::post('download', [
        'as' => 'reactor.update.download',
        'uses' => 'UpdateController@download']);
    Route::post('extract', [
        'as' => 'reactor.update.extract',
        'uses' => 'UpdateController@extract']);
    Route::post('move', [
        'as' => 'reactor.update.move',
        'uses' => 'UpdateController@move']);
    Route::post('finalize', [
        'as' => 'reactor.update.finalize',
        'uses' => 'UpdateController@finalize']);

});