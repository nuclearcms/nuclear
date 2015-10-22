<?php

namespace Reactor\Http\Presenters\Documents;


use Laracasts\Presenter\Presenter;

class MediaPresenter extends Presenter {

    /**
     * Icon classes for mimetypes
     *
     * @var array
     */
    protected $icons = [
        'application/pdf' => 'icon-file-pdf',
        'application/msword' => 'icon-file-word',
        'application/vnd.ms-excel' => 'icon-file-excel',
        'application/vnd.ms-powerpoint' => 'icon-file-powerpoint',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'icon-file-word',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'icon-file-powerpoint',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'icon-file-excel',
        'audio/aac' => 'icon-file-audio',
        'audio/mp4' => 'icon-file-audio',
        'audio/mpeg' => 'icon-file-audio',
        'audio/ogg' => 'icon-file-audio',
        'audio/wav' => 'icon-file-audio',
        'audio/webm' => 'icon-file-audio',
        'video/mp4' => 'icon-file-video',
        'video/ogg' => 'icon-file-video',
        'video/webm' => 'icon-file-video',
        'video/youtube' => 'icon-youtube-play',
        'video/vimeo' => 'icon-vimeo',
        'audio/soundcloud' => 'icon-soundcloud'
    ];

    public function thumbnail()
    {
        if ($this->type === 'image')
        {
            return '<img src="' . url(config('imagecache.route') . '/rthumb/' . $this->path) . '">';
        }

        if (array_key_exists($this->mimetype, $this->icons))
        {
            return '<i class="' . $this->icons[$this->mimetype] . '"></i>';
        }

        return '<i class="icon-doc"></i>';
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
        return '';
    }

}