<?php

namespace Reactor\Http\Presenters\Documents;


use Laracasts\Presenter\Presenter;

class EmbedPresenter extends Presenter {

    public function tag()
    {
        return $this->path;
    }

    public function preview()
    {
        return '<div class="document-preview">' .
        \Oembed::cache($this->path, ['lifetime' => 43200])->code .
        '</div>';
    }

}