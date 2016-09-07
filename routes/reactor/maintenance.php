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

    // Optimize
    Route::post('optimize', [
        'as' => 'reactor.maintenance.optimize',
        'uses' => 'MaintenanceController@optimizeApp']);
    Route::post('cache/routes', [
        'as' => 'reactor.maintenance.cache.routes',
        'uses' => 'MaintenanceController@cacheRoutes']);
    Route::post('nodes/tree', [
        'as' => 'reactor.maintenance.nodes.tree',
        'uses' => 'MaintenanceController@fixNodesTree']);
    Route::post('key', [
        'as' => 'reactor.maintenance.key',
        'uses' => 'MaintenanceController@regenerateKey']);

    // Backup
    Route::post('backup', [
        'as' => 'reactor.maintenance.backup.create',
        'uses' => 'MaintenanceController@createBackup']);

    // Cleanup
    Route::post('clear/view', [
        'as' => 'reactor.maintenance.clear.views',
        'uses' => 'MaintenanceController@clearViews']);
    Route::post('clear/cache', [
        'as' => 'reactor.maintenance.clear.cache',
        'uses' => 'MaintenanceController@clearCache']);
    Route::post('clear/password', [
        'as' => 'reactor.maintenance.clear.password',
        'uses' => 'MaintenanceController@clearPasswords']);

    Route::post('clear/statistics', [
        'as' => 'reactor.maintenance.clear.statistics',
        'uses' => 'MaintenanceController@clearAllTrackerViews']);
    Route::post('clear/statistics/year', [
        'as' => 'reactor.maintenance.clear.statistics.year',
        'uses' => 'MaintenanceController@clearTrackerViewsOlderYear']);
    Route::post('clear/statistics/month', [
        'as' => 'reactor.maintenance.clear.statistics.month',
        'uses' => 'MaintenanceController@clearTrackerViewsOlderMonth']);

    Route::post('clear/activities', [
        'as' => 'reactor.maintenance.clear.activities',
        'uses' => 'MaintenanceController@clearActivities']);

    Route::post('clear/activities/year', [
        'as' => 'reactor.maintenance.clear.activities.year',
        'uses' => 'MaintenanceController@clearActivitiesOlderYear']);

    Route::post('clear/activities/month', [
        'as' => 'reactor.maintenance.clear.activities.month',
        'uses' => 'MaintenanceController@clearActivitiesOlderMonth']);

});