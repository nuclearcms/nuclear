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
    'media_model' => 'Reactor\Documents\Media',

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
        'audio'            => [
            'audio/aac', 'audio/mp4', 'audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/webm'
        ],
        'document'         => [
            'text/plain', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ],
        'image'            => [
            'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'
        ],
        'video'            => [
            'video/mp4', 'video/ogg', 'video/webm'
        ],
        'video-youtube'    => ['video/youtube'],
        'video-vimeo'      => ['video/vimeo'],
        'audio-soundcloud' => ['audio/soundcloud'],
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
        'audio'            => 'Reactor\Documents\Audio',
        'document'         => 'Reactor\Documents\Document',
        'image'            => 'Reactor\Documents\Image',
        'video'            => 'Reactor\Documents\Video',
        'video-youtube'    => 'Reactor\Documents\YoutubeVideo',
        'video-vimeo'      => 'Reactor\Documents\VimeoVideo',
        'audio-soundcloud' => 'Reactor\Documents\SoundcloudAudio',
    ]

];