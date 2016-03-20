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

];