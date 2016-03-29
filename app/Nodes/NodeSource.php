<?php

namespace Reactor\Nodes;

use Nuclear\Hierarchy\NodeSource as HierarchyNodeSource;

class NodeSource extends HierarchyNodeSource {

    /**
     * The fillable fields for the model.
     */
    protected $fillable = ['title', 'node_name',
        'meta_title', 'meta_keywords', 'meta_description', 'meta_author', 'meta_image'];

    protected $baseAttributesAndRelations = [
        'id', 'node_id', 'title', 'node_name', 'locale', 'source_type',
        'meta_title', 'meta_keywords', 'meta_description', 'meta_author', 'meta_image',
        'source', 'node'];

}