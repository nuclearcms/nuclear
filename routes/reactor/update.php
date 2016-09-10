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

});