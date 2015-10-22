<?php

namespace Reactor\Documents;


class SoundcloudAudio extends Media {

    /**
     * @var string
     */
    protected $mediaType = 'audio-soundcloud';

    /**
     * Presenter for the model
     *
     * @var string
     */
    protected $presenter = 'Reactor\Http\Presenters\Documents\SoundcloudAudioPresenter';

}