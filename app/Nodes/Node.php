<?php

namespace Reactor\Nodes;


use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Ownable\AutoAssociatesOwner;
use Kenarkose\Ownable\Ownable;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Nuclear\Hierarchy\Node as HierarchyNode;
use Reactor\Tags\Tag;

class Node extends HierarchyNode {

    use SearchableTrait, Ownable, AutoAssociatesOwner, RecordsActivity;

    /**
     * Sortable trait requires minor tweaks
     */
    use Sortable
    {
        scopeSortable as _scopeSortable;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'node_name',
        'meta_title', 'meta_keywords', 'meta_description', 'meta_image', 'meta_author',
        'visible', 'sterile', 'home', 'locked', 'status', 'hides_children', 'priority',
        'published_at', 'children_order', 'children_order_direction', 'children_display_mode'];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'node_sources.title'         => 10,
            'node_sources.meta_keywords' => 10
        ],
        'joins'   => [
            'node_sources' => ['nodes.id', 'node_sources.node_id'],
        ]
    ];

    /**
     * Table for the model
     *
     * We hardcode this since we would like to keep
     * the child classes in the same table
     */
    protected $table = 'nodes';

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['title', 'created_at'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'created_at';

    /**
     * Default sortable direction
     *
     * @var string
     */
    protected $sortableDirection = 'desc';

    /**
     * Determines the default link for node
     *
     * @param null|string $locale
     * @return string
     */
    public function getDefaultLink($locale = null)
    {
        $parameters = [
            $this->getKey(),
            $this->translate($locale)->getKey()
        ];

        if ($this->hidesChildren())
        {
            return route('reactor.contents.' . $this->children_display_mode,
                $parameters);
        }

        return route('reactor.contents.edit',
            $parameters);
    }

    /**
     * Sortable by scope
     *
     * @param $query
     * @param string|null $key
     * @param string|null $direction
     * @return $query
     */
    public function scopeSortable($query, $key = null, $direction = null)
    {
        list($key, $direction) = $this->validateSortableParameters($key, $direction);

        if ($this->_isTranslationAttribute($key))
        {
            return $this->orderQueryBySourceAttribute($query, $key, $direction);
        }

        return $query->orderBy($key, $direction);
    }

    /**
     * Checks if node is taggable
     *
     * @return bool
     */
    public function isTaggable()
    {
        return (bool)$this->nodeType->taggable;
    }


    /**
     * Tag relation
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}