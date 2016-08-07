<?php

Route::get('/', [
    'uses' => 'DashboardController@index',
    'as'   => 'reactor.dashboard']);