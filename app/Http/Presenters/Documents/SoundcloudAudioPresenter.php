<?php

namespace Reactor\Http\Presenters\Documents;


class SoundcloudAudioPresenter extends EmbedPresenter {

    public function thumbnail()
    {
        return '<i class="icon-soundcloud"></i>';
    }

}