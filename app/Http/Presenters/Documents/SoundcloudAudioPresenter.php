<?php

namespace Reactor\Http\Presenters\Documents;


class SoundcloudAudioPresenter extends Presenter {

    public function thumbnail()
    {
        return '<i class="icon-soundcloud">';
    }

    public function tag()
    {
        return 'soundcloud url?';
    }

    public function preview()
    {
        return 'soundcloud embed';
    }

}