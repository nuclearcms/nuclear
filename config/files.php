<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Default Media Model
	|--------------------------------------------------------------------------
	|
	| You may configure the default media class path here.
	|
	*/
    'media_model' => 'Kenarkose\Files\Media\Media',

    /*
	|--------------------------------------------------------------------------
	| Media Types
	|--------------------------------------------------------------------------
	|
	| Determine media type keys here for the file mime types which will be
    | used for auto determining. These keys should correspond to the key
    | properties that are defined in the media models.
	|
	*/
    'media_types' => [
        'audio'    => [
            'audio/aac', 'audio/mp4', 'audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/webm'
        ],
        'document' => [
            'text/plain', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint'
        ],
        'image'    => [
            'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'
        ],
        'video'    => [
            'video/mp4', 'video/ogg', 'video/webm'
        ]
    ],

    /*
	|--------------------------------------------------------------------------
	| Model Types
	|--------------------------------------------------------------------------
	|
	| You may define the media models which correspond to the media types here.
	|
	*/
    'model_types' => [
        'audio'    => 'Kenarkose\Files\Media\Audio',
        'document' => 'Kenarkose\Files\Media\Document',
        'image'    => 'Kenarkose\Files\Media\Image',
        'video'    => 'Kenarkose\Files\Media\Video'
    ]

];