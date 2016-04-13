<?php

namespace Reactor\Http\Presenters\Documents;


use Laracasts\Presenter\Presenter;

class ImagePresenter extends Presenter {

    public function thumbnail()
    {
        return $this->cachedWith('rthumb');
    }

    public function cachedWith($process)
    {
        return '<img src="' . $this->cachedRoute($process) . '">';
    }

    public function cachedRoute($process)
    {
        return url(config('imagecache.route') . '/' . $process . '/' . $this->path);
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
        return '<figure class="document-preview">' .
            $this->original() .
        '</figure>';
    }

    public function original()
    {
        return '<img src="' . uploaded_asset($this->path) . '">';
    }

}