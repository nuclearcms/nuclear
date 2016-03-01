<?php

namespace Reactor\Documents;


use Illuminate\Database\Eloquent\Model as Eloquent;

class MediaTranslation extends Eloquent {

    public $timestamps = false;
    protected $fillable = ['caption', 'description'];

}