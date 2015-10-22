<?php

namespace Reactor\Documents;


class VimeoVideo extends Media {

    /**
     * @var string
     */
    protected $mediaType = 'video-vimeo';

    /**
     * Presenter for the model
     *
     * @var string
     */
    protected $presenter = 'Reactor\Http\Presenters\Documents\VimeoVideoPresenter';

}