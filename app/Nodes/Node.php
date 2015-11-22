<?php

namespace Reactor\Nodes;


use Nicolaslopezj\Searchable\SearchableTrait;
use Nuclear\Hierarchy\Node as HierarchyNode;

class Node extends HierarchyNode {

    use SearchableTrait;

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