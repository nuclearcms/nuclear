<?php

namespace Reactor\Tags;


use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model {

    /**
     * The fillable fields for the model.
     *
     * @var  array
     */
    protected $fillable = ['name', 'slug'];

    public $timestamps = false;

    /**
     * Boot the model
     */
    public static function boot()
    {
        TagTranslation::saving(function ($translation)
        {
            $translation->setSlugFromName();
        });
    }

    /**
     * Sets the tag slug
     *
     * @param string
     * @return void
     */
    public function setSlugFromName()
    {
        $this->setAttribute('slug',
            str_slug($this->getAttribute('name')));
    }

    /**
     * Returns the tag translation by slug
     *
     * @param string $slug
     * @return TagTranslation
     */
    public static function findBySlug($slug)
    {
        return static::whereSlug($slug)->first();
    }

    /**
     * Tag relation
     *
     * @return BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo('Reactor\Tags\Tag');
    }
}
