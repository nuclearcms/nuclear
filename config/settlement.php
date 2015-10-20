<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Driver
	|--------------------------------------------------------------------------
	|
	| Driver which will be registered by the service provider.
    | Drivers must implement the Kenarkose\Settlement\Contract\Repository interface.
    | The default driver is Kenarkose\Settlement\Repository\LaravelJSONRepository.
	|
	*/
    'driver' => 'Reactor\Settlement\SettingsRepository',

    /*
	|--------------------------------------------------------------------------
	| JSON.Path
	|--------------------------------------------------------------------------
	|
	| Path for JSON driver to load and save the json file.
	|
	*/
    'path' => storage_path('app'),

    /*
	|--------------------------------------------------------------------------
	| JSON.Filename
	|--------------------------------------------------------------------------
	|
	| File name for the JSON file that driver to loads from and saves to.
	|
	*/
    'filename' => 'settings.json',

];