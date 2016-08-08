<?php

Route::group([
    'prefix' => 'maintenance',
    'middleware' => 'can:ACCESS_MAINTENANCE'
], function ()
{

    Route::get('/', [
        'uses' => 'MaintenanceController@index',
        'as' => 'reactor.maintenance.index'
    ]);

});