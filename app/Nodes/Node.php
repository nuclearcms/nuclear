<?php

namespace Reactor\Nodes;


use Nuclear\Hierarchy\Node as HierarchyNode;

class Node extends HierarchyNode {

    /**
     * Table for the model
     *
     * We hardcode this since we would like to keep
     * the child classes in the same table
     */
    protected $table = 'nodes';

}