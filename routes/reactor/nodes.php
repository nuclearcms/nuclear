<?php

Route::group([
    'prefix' => 'nodes',
    'middleware' => 'can:ACCESS_NODES'
], function ()
{
    // @todo Resource controller here?
    Route::get('/', [
        'uses' => 'NodesController@index',
        'as' => 'reactor.nodes.index'
    ]);

});