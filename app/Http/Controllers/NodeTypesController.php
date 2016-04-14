<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\Repositories\NodeTypeRepository;
use Reactor\Http\Controllers\Traits\UsesNodeTypeForms;
use Reactor\Http\Requests;
use Reactor\Nodes\Node;
use Reactor\Nodes\NodeType;

class NodeTypesController extends ReactorController {

    use UsesNodeTypeForms;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodeTypes = NodeType::sortable()->paginate();

        return view('nodetypes.index')
            ->with(compact('nodeTypes'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $nodeTypes = NodeType::search($request->input('q'), 20, true)->get();

        return view('nodetypes.search')
            ->with(compact('nodeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('ACCESS_NODES_CREATE');

        $form = $this->getCreateNodeTypeForm();

        return view('nodetypes.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NodeTypeRepository $nodeTypeRepository
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NodeTypeRepository $nodeTypeRepository, Request $request)
    {
        $this->authorize('ACCESS_NODES_CREATE');

        $this->validateForm('Reactor\Http\Forms\Nodes\CreateNodeTypeForm', $request);

        $nodeType = $nodeTypeRepository->create($request->all());

        $this->notify('nodes.created_type');

        return redirect()->route('reactor.nodes.edit', $nodeType->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $nodeType = NodeType::findOrFail($id);

        $form = $this->getEditNodeTypeForm($id, $nodeType);

        return view('nodetypes.edit', compact('form', 'nodeType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $nodeType = NodeType::findOrFail($id);

        $this->validateForm('Reactor\Http\Forms\Nodes\EditNodeTypeForm', $request);

        $nodeType->update($request->all());

        $this->notify('nodes.edited_type');

        return redirect()->route('reactor.nodes.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NodeTypeRepository $nodeTypeRepository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NodeTypeRepository $nodeTypeRepository, $id)
    {
        $this->authorize('ACCESS_NODES_DELETE');

        $nodeTypeRepository->destroy($id);

        $this->notify('nodes.deleted_type');

        return redirect()->route('reactor.nodes.index');
    }

    /**
     * List the specified resource fields.
     *
     * @param int $id
     * @return Response
     */
    public function fields($id)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $nodeType = NodeType::findOrFail($id);

        return view('nodetypes.fields', compact('nodeType'));
    }

    /**
     * List the specified resource fields.
     *
     * @param int $id
     * @return Response
     */
    public function nodes($id)
    {
        $this->authorize('ACCESS_CONTENTS');

        $nodeType = NodeType::findOrFail($id);

        $nodes = Node::where('node_type_id', $nodeType->getKey())
            ->sortable()->paginate();

        return view('nodetypes.nodes', compact('nodeType', 'nodes'));
    }

}
