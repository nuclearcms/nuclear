<?php

namespace Reactor\Documents;


class YoutubeVideo extends Media {

    /**
     * @var string
     */
    protected $mediaType = 'video-youtube';

    /**
     * Presenter for the model
     *
     * @var string
     */
    protected $presenter = 'Reactor\Http\Presenters\Documents\YoutubeVideoPresenter';

}