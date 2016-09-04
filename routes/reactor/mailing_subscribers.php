<?php

Route::resource('subscribers', 'MailingSubscribersController', ['except' => 'show', 'names' => [
    'index'   => 'reactor.mailing_subscribers.index',
    'create'  => 'reactor.mailing_subscribers.create',
    'store'   => 'reactor.mailing_subscribers.store',
    'edit'    => 'reactor.mailing_subscribers.edit',
    'update'  => 'reactor.mailing_subscribers.update',
    'destroy' => 'reactor.mailing_subscribers.destroy',
]]);

Route::get('subscribers/search', [
    'uses' => 'MailingSubscribersController@search',
    'as'   => 'reactor.mailing_subscribers.search']);

Route::delete('subscribers/destroy/bulk', [
    'uses' => 'MailingSubscribersController@bulkDestroy',
    'as'   => 'reactor.mailing_subscribers.destroy.bulk']);