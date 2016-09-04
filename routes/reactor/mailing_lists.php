<?php

Route::resource('lists', 'MailingListsController', ['except' => 'show', 'names' => [
    'index'   => 'reactor.mailing_lists.index',
    'create'  => 'reactor.mailing_lists.create',
    'store'   => 'reactor.mailing_lists.store',
    'edit'    => 'reactor.mailing_lists.edit',
    'update'  => 'reactor.mailing_lists.update',
    'destroy' => 'reactor.mailing_lists.destroy',
]]);

Route::get('lists/search', [
    'uses' => 'MailingListsController@search',
    'as'   => 'reactor.mailing_lists.search']);

Route::delete('lists/destroy/bulk', [
    'uses' => 'MailingListsController@bulkDestroy',
    'as'   => 'reactor.mailing_lists.destroy.bulk']);