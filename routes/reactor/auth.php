<?php

Route::get('auth/login', [
    'uses' => 'Auth\AuthController@getLogin',
    'as'   => 'reactor.auth.login']);