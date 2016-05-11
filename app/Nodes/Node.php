<?php

namespace Reactor\Nodes;


use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Ownable\AutoAssociatesOwner;
use Kenarkose\Ownable\Ownable;
use Kenarkose\Sortable\Sortable;
use Kenarkose\Tracker\Trackable;
use Kenarkose\Tracker\TrackableInterface;
use Nicolaslopezj\Searchable\SearchableTrait;
use Nuclear\Hierarchy\Node as HierarchyNode;
use Reactor\Tags\Tag;

class Node extends HierarchyNode implements TrackableInterface {

    use SearchableTrait, Ownable, AutoAssociatesOwner, RecordsActivity, Trackable;

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
            'node_sources.title'         => 50,
            'node_sources.meta_keywords' => 20
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
     * The translation model is the NodeSource for use
     * and the table name
     *
     * @var string
     */
    protected $translationModel = 'Reactor\Nodes\NodeSource';

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
     * Tracker relation configuration
     *
     * We are being explicit here to be able to extend
     * with different models
     */
    protected $trackerPivotTable = 'node_site_view';
    protected $trackerForeignKey = 'node_id';

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
            $this->translateOrFirst($locale)->getKey()
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
        return $this->belongsToMany(Tag::class, 'node_tag', 'node_id', 'tag_id');
    }

    /**
     * Links a tag to the node
     *
     * @param int $id
     */
    public function attachTag($id)
    {
        if ( ! $this->tags->contains($id))
        {
            return $this->tags()->attach($id);
        }
    }

    /**
     * Unlinks a tag from the node
     *
     * @param int $id
     */
    public function detachTag($id)
    {
        return $this->tags()->detach($id);
    }

    /**
     * Most visited scope
     *
     * @param Builder $query
     * @param int|null $limit
     * @return Builder
     */
    public function scopeMostVisited($query, $limit = null)
    {
        $query->select(\DB::raw('nodes.*, count(*) as `aggregate`'))
            ->join('node_site_view', 'nodes.id', '=', 'node_site_view.node_id')
            ->groupBy('nodes.id')
            ->orderBy('aggregate', 'desc');

        if ($limit)
        {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Recently visited scope
     *
     * @param Builder $query
     * @param int|null $limit
     * @return Builder
     */
    public function scopeRecentlyVisited($query, $limit = null)
    {
        $query
            ->select(\DB::raw('nodes.*, MAX(node_site_view.site_view_id) as `aggregate`'))
            ->join('node_site_view', 'nodes.id', '=', 'node_site_view.node_id')
            ->orderBy('aggregate', 'desc')
            ->groupBy('node_site_view.node_id');

        if ($limit)
        {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Recently edited scope
     *
     * @param Builder $query
     * @param int|null $limit
     * @return Builder
     */
    public function scopeRecentlyEdited($query, $limit = null)
    {
        $query->orderBy('updated_at', 'desc');

        if ($limit)
        {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Recently created scope
     *
     * @param Builder $query
     * @param int|null $limit
     * @return Builder
     */
    public function scopeRecentlyCreated($query, $limit = null)
    {
        $query->orderBy('created_at', 'desc');

        if ($limit)
        {
            $query->limit($limit);
        }

        return $query;
    }

}