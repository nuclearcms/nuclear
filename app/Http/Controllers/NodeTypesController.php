<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\NodeType;
use Reactor\Http\Controllers\Traits\UsesNodeTypeForms;
use Reactor\Http\Controllers\Traits\BasicResource;

class NodeTypesController extends ReactorController {

    use BasicResource, UsesNodeTypeForms;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = NodeType::class;
    protected $resourceMultiple = 'nodetypes';
    protected $resourceSingular = 'nodetype';
    protected $permissionKey = 'NODETYPES';

    /**
     * Searches nodetypes intended for nodes
     *
     * @param Request $request
     * @return Response
     */
    public function searchTypeNodes(Request $request)
    {
        $nodeTypes = NodeType::forNodes()
            ->search($request->input('q'), 20, true)
            ->limit(10)->get();

        return response()->json(
            $nodeTypes->pluck('label', 'id')->toArray()
        );
    }

}