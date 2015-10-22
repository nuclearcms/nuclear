<?php

namespace Reactor\Http\Presenters\Documents;


use Laracasts\Presenter\Presenter;

class YoutubeVideoPresenter extends Presenter {

    public function thumbnail()
    {
        return '<i class="icon-youtube-play">';
    }

    public function tag()
    {
        return 'youtube url?';
    }

    public function preview()
    {
        return 'youtube embed';
    }

}