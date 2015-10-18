<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Switch this package on/off. Useful for testing...
    |--------------------------------------------------------------------------
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Set behavior if an asset is not found in a Theme hierarchy.
    | Available options: THROW_EXCEPTION | LOG_ERROR | IGNORE
    |--------------------------------------------------------------------------
    */

    'asset_not_found' => 'LOG_ERROR',

    /*
    |--------------------------------------------------------------------------
    | Set the Active Theme. Can be set at runtime with:
    |  Themes::set('theme-name');
    |--------------------------------------------------------------------------
    */

    'active' => 'default',
    'active_reactor' => 'reactor',

    /*
    |--------------------------------------------------------------------------
    | Define available themes. Format:
    |
    | 	'theme-name' => [
    | 		'extends'	 	=> 'theme-to-extend',  // optional
    | 		'views-path' 	=> 'path-to-views',    // defaults to: resources/views/theme-name
    | 		'asset-path' 	=> 'path-to-assets',   // defaults to: public/theme-name
    |
    |		// you can add your own custom keys and retrieve them with Theme::config('key');
    | 	],
    |
    |--------------------------------------------------------------------------
    */

    'themes' => [

        'default' => [
            'extends'    => null,
            'views-path' => '',
            'asset-path' => '',
        ],

        'reactor' => [
            'extends'    => null,
            'views-path' => 'reactor',
            'asset-path' => 'reactor_assets',
        ],

    ],

];
