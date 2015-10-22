<?php

namespace Reactor\Http\Presenters\Documents;


use Laracasts\Presenter\Presenter;

class ImagePresenter extends Presenter {

    public function thumbnail()
    {
        return '<img src="' . url(config('imagecache.route') . '/rthumb/' . $this->path) . '">';
    }

    public function tag()
    {
        return sprintf('%s | %s',
            $this->mimetype,
            readable_size($this->size)
        );
    }

    public function preview()
    {
        return $this->originalPreview();
    }

    public function originalPreview()
    {
        return '<figure class="document-preview">
            <img src="' . uploaded_asset($this->path) . '">
        </figure>';
    }

}