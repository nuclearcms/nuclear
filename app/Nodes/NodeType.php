<?php

namespace Reactor\Nodes;

use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Nuclear\Hierarchy\NodeType as HierarchyNodeType;

class NodeType extends HierarchyNodeType
{
    use Sortable, SearchableTrait, RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'description',
        'visible', 'hides_children', 'color',
        'taggable', 'route_template', 'preview_template'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['name', 'label'];

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
            'name'  => 10,
            'label' => 10
        ]
    ];

    /**
     * Checks if the NodeType has a preview template
     *
     * @return bool
     */
    public function hasPreviewTemplate()
    {
        return ! empty($this->preview_template);
    }

    /**
     * Checks if the NodeType has a route template
     *
     * @return bool
     */
    public function hasRouteTemplate()
    {
        return ! empty($this->route_template);
    }

}
