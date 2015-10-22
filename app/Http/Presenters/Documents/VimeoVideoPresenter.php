<?php

namespace Reactor\Http\Presenters\Documents;


use Laracasts\Presenter\Presenter;

class VimeoVideoPresenter extends Presenter {

    public function thumbnail()
    {
        return '<i class="icon-vimeo">';
    }

    public function tag()
    {
        return 'vimeo url?';
    }

    public function preview()
    {
        return 'vimeo embed';
    }

}