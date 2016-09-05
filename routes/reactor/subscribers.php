<?php

Route::resource('subscribers', 'SubscribersController', ['except' => 'show', 'names' => [
    'index'   => 'reactor.subscribers.index',
    'create'  => 'reactor.subscribers.create',
    'store'   => 'reactor.subscribers.store',
    'edit'    => 'reactor.subscribers.edit',
    'update'  => 'reactor.subscribers.update',
    'destroy' => 'reactor.subscribers.destroy',
]]);

Route::get('subscribers/search', [
    'uses' => 'SubscribersController@search',
    'as'   => 'reactor.subscribers.search']);

Route::delete('subscribers/destroy/bulk', [
    'uses' => 'SubscribersController@bulkDestroy',
    'as'   => 'reactor.subscribers.destroy.bulk']);

Route::get('subscribers/{id}/lists', [
    'uses' => 'SubscribersController@lists',
    'as'   => 'reactor.subscribers.lists']);
Route::put('subscribers/{id}/lists', [
    'uses' => 'SubscribersController@associateList',
    'as'   => 'reactor.subscribers.lists.associate']);
Route::delete('subscribers/{id}/lists', [
    'uses' => 'SubscribersController@dissociateList',
    'as'   => 'reactor.subscribers.lists.dissociate']);