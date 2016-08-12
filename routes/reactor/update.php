<?php

Route::group([
    'prefix' => 'update',
    'middleware' => 'can:ACCESS_UPDATE'
], function ()
{

    Route::get('/', [
        'uses' => 'UpdateController@index',
        'as' => 'reactor.update.index']);

});