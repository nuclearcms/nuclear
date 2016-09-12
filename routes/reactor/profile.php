<?php

Route::group(['prefix' => 'profile'], function ()
{

    Route::get('/', [
        'uses' => 'ProfileController@edit',
        'as'   => 'reactor.profile.edit']);
    Route::put('/', [
        'uses' => 'ProfileController@update',
        'as'   => 'reactor.profile.update']);

    Route::get('password', [
        'uses' => 'ProfileController@password',
        'as'   => 'reactor.profile.password']);
    Route::put('password', [
        'uses' => 'ProfileController@updatePassword',
        'as'   => 'reactor.profile.password.post']);

    Route::get('activity', [
        'uses' => 'ProfileController@activity',
        'as'   => 'reactor.profile.activity']);

});