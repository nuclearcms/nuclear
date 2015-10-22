<?php

namespace Reactor\Http\Presenters\Documents;


class YoutubeVideoPresenter extends EmbedPresenter {

    public function thumbnail()
    {
        return '<i class="icon-youtube-play"></i>';
    }

}