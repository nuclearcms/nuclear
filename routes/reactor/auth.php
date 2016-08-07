<?php

// Authentication
Route::get('auth/login', [
    'uses' => 'Auth\AuthController@getLogin',
    'as'   => 'reactor.auth.login']);
Route::post('auth/login', [
    'uses' => 'Auth\AuthController@postLogin',
    'as'   => 'reactor.auth.login.post']);
Route::get('auth/logout', [
    'uses' => 'Auth\AuthController@getLogout',
    'as'   => 'reactor.auth.logout']);

// Password Reset
Route::get('password/email', [
    'uses' => 'Auth\PasswordController@getEmail',
    'as'   => 'reactor.password.email']);
Route::post('password/email', [
    'uses' => 'Auth\PasswordController@postEmail',
    'as'   => 'reactor.password.email.post']);

Route::get('password/reset/{token}', [
    'uses' => 'Auth\PasswordController@getReset',
    'as'   => 'reactor.password.reset']);
Route::post('password/reset', [
    'uses' => 'Auth\PasswordController@postReset',
    'as'   => 'reactor.password.reset.post']);