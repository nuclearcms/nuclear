<?php

namespace Reactor\Tags;


use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Reactor\Nodes\Node;

class Tag extends Model {

    use Translatable, SearchableTrait;

    use Sortable
    {
        scopeSortable as _scopeSortable;
    }

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The fillable fields for the model.
     *
     * @var  array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Translatable
     */
    public $translatedAttributes = ['name', 'slug'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['name', 'created_at'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'name';

    /**
     * Default sortable direction
     *
     * @var string
     */
    protected $sortableDirection = 'asc';

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'tag_translations.name' => 10,
            'tag_translations.slug' => 10
        ],
        'joins'   => [
            'tag_translations' => ['tags.id', 'tag_translations.tag_id']
        ]
    ];

    /**
     * Node relation
     *
     * @return BelongsToMany
     */
    public function nodes()
    {
        return $this->belongsToMany(Node::class);
    }

    /**
     * Sortable by scope
     *
     * @param $query
     * @param string|null $key
     * @param string|null $direction
     * @return Builder
     */
    public function scopeSortable($query, $key = null, $direction = null)
    {
        list($key, $direction) = $this->validateSortableParameters($key, $direction);

        if ($this->isTranslationAttribute($key))
        {
            return $this->orderByTranslationAttribute($query, $key, $direction);
        }

        return $query->orderBy($key, $direction);
    }

    /**
     * @param Builder $query
     * @param $attribute
     * @param $direction
     * @return mixed
     */
    protected function orderByTranslationAttribute(Builder $query, $attribute, $direction)
    {
        $key = $this->getTable() . '.' . $this->getKeyName();

        return $query->join($this->getTranslationsTable() . ' as t', 't.tag_id', '=', $key)
            ->select('t.id as translation_id', 'tags.*')
            ->groupBy($key)
            ->orderBy('t.' . $attribute, $direction);
    }

    /**
     * Finds a tag by name or creates it
     *
     * @param string $name
     * @return Tag
     */
    public static function firstByNameOrCreate($name)
    {
        $tag = Tag::whereTranslation('name', $name)->first();

        if (is_null($tag))
        {
            $tag = Tag::create(compact('name'));
        }

        return $tag;
    }

    /**
     * Returns locale for slug
     *
     * @param string $slug
     * @return string
     */
    public function getLocaleForName($slug)
    {
        foreach ($this->translations as $translation)
        {
            if ($translation->slug === $slug)
            {
                return $translation->locale;
            }
        }

        return null;
    }

    /**
     * Scope for selecting with slug
     *
     * @param Builder $query
     * @param string $slug
     * @return Builder
     */
    public function scopeWithSlug(Builder $query, $slug)
    {
        return $this->scopeWhereTranslation($query, 'slug', $slug);
    }

}
