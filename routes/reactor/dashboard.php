<?php

Route::get('/', [
    'uses' => 'DashboardController@index',
    'as'   => 'reactor.dashboard']);

Route::get('activity', [
    'uses' => 'DashboardController@activity',
    'as'   => 'reactor.dashboard.activity']);