<?php

namespace Reactor\Nodes;


class PublishedNode extends Node {

    /**
     * Boot the model
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PublishedScope);
    }

}