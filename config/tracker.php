<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Enable/Disable Tracker
	|--------------------------------------------------------------------------
	|
	| By default Tracker persists the site view when site view is accessed
    | manually by using getCurrent method or through the
    | TrackerMiddleware. To disable persistence set this value to false.
	|
	*/
    'enabled' => true,

    /*
	|--------------------------------------------------------------------------
	| Site View Model
	|--------------------------------------------------------------------------
	|
	| Model which records site views.
    | Default model is 'Kenarkose\Tracker\SiteView'.
	|
	*/
    'model' => 'Kenarkose\Tracker\SiteView',

    /*
	|--------------------------------------------------------------------------
	| Bot Filters
	|--------------------------------------------------------------------------
	|
	| Keywords for filtering bots from actual human requests.
    | This filter is used with the http_user_agent param.
    |
    | @link http://www.user-agents.org/
	|
	*/
    'bot_filter' => [
        'bot',
        'spider',
        'pingbot',
        'googlebot',
        'google',
        'yandexbot',
        'yandex',
        'bingbot',
        'curl',
        'facebook',
        'python',
        'pinterest',
        'twitter',
        'archive',
        'ltx71',
        'java',
        'slurp',
        'wow64',
        'qwant',
        'msie 6.0',
        'dotbot',
        'windows nt',
        'feedfetcher',
        'metauri'
    ],

];