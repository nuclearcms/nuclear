<?php

// Authentication
Route::get('auth/login', [
    'uses' => 'Auth\AuthController@showLoginForm',
    'as'   => 'reactor.auth.login']);
Route::post('auth/login', [
    'uses' => 'Auth\AuthController@login',
    'as'   => 'reactor.auth.login.post']);
Route::get('auth/logout', [
    'uses' => 'Auth\AuthController@logout',
    'as'   => 'reactor.auth.logout']);

// Password Reset
Route::get('password/email', [
    'uses' => 'Auth\PasswordController@showEmailForm',
    'as'   => 'reactor.password.email']);
Route::post('password/email', [
    'uses' => 'Auth\PasswordController@sendResetLinkEmail',
    'as'   => 'reactor.password.email.post']);

Route::get('password/reset/{token}', [
    'uses' => 'Auth\PasswordController@showResetForm',
    'as'   => 'reactor.password.reset']);
Route::post('password/reset', [
    'uses' => 'Auth\PasswordController@reset',
    'as'   => 'reactor.password.reset.post']);