<?php

Route::get('dashboard', [
    'uses' => 'DashboardController@index',
    'as'   => 'reactor.dashboard']);