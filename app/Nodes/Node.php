<?php

namespace Reactor\Nodes;


use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Ownable\AutoAssociatesOwner;
use Kenarkose\Ownable\Ownable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Nuclear\Hierarchy\Node as HierarchyNode;

class Node extends HierarchyNode {

    use SearchableTrait, Ownable, AutoAssociatesOwner, RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'node_name',
        'meta_title', 'meta_keywords', 'meta_description',
        'visible', 'sterile', 'home', 'locked', 'status', 'hides_children', 'priority',
        'published_at', 'children_order', 'children_order_direction', 'children_display_mode'];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'node_sources.title' => 10,
            'node_sources.meta_keywords'  => 10
        ],
        'joins' => [
            'node_sources' => ['nodes.id','node_sources.node_id'],
        ]
    ];

    /**
     * Table for the model
     *
     * We hardcode this since we would like to keep
     * the child classes in the same table
     */
    protected $table = 'nodes';

}