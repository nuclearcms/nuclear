<?php

namespace Reactor\Documents;


class Image extends Media {

    /**
     * @var string
     */
    protected $mediaType = 'image';

    /**
     * Presenter for the model
     *
     * @var string
     */
    protected $presenter = 'Reactor\Http\Presenters\Documents\ImagePresenter';

}