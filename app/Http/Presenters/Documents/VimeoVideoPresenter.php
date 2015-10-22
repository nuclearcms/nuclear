<?php

namespace Reactor\Http\Presenters\Documents;


class VimeoVideoPresenter extends EmbedPresenter {

    public function thumbnail()
    {
        return '<i class="icon-vimeo"></i>';
    }

}