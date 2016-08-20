<?php


namespace Reactor\Http\Controllers;


use Nuclear\Hierarchy\NodeType;
use Reactor\Http\Controllers\Traits\BasicResource;

class NodeTypesController extends ReactorController {

    use BasicResource;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = NodeType::class;
    protected $resourceMultiple = 'nodetypes';
    protected $resourceSingular = 'nodetype';
    protected $permissionKey = 'NODETYPES';

}