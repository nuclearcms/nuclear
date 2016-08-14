<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Enable / Disable Recording
	|--------------------------------------------------------------------------
	|
	| By default Chronicle is enabled. If you would like to disable recording
    | set this option to false.
	|
	*/
    'enabled' => true,

    /*
	|--------------------------------------------------------------------------
	| Activity Model
	|--------------------------------------------------------------------------
	|
	| Model which records the activities.
    | Default model is 'Kenarkose\Chronicle\Activity'.
	|
	*/
    'model' => 'Kenarkose\Chronicle\Activity',

    /*
    |--------------------------------------------------------------------------
    | Default User Model
    |--------------------------------------------------------------------------
    |
    | This option is for determining the default owner model. If not determined
    | with the property in the Activity model, the owner is instantiated with
    | the class determined below.
    |
    */

    'user_model' => Nuclear\Users\User::class,

];