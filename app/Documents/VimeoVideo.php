<?php

namespace Reactor\Documents;


class VimeoVideo extends Media {

    use Embeddable;

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