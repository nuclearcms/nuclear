<?php

namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\Http\Requests;
use Reactor\Nodes\NodeType;

class NodeTypesController extends ReactorController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodeTypes = NodeType::sortable()->paginate();

        return view('nodes.index')
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
        $nodeTypes = NodeType::search($request->input('q'))->get();

        return view('nodes.search')
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

        return view('nodes.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('ACCESS_NODES_CREATE');

        $this->validateForm('Nodes\CreateNodeTypeForm', $request);

        $nodeType = NodeType::create($request->all());

        $this->notify('nodes.created');

        return redirect()->route('reactor.nodes.edit', $nodeType->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $nodeType = NodeType::findOrFail($id);

        $form = $this->getEditNodeTypeForm($id, $nodeType);

        return view('nodes.edit', compact('form', 'nodeType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $nodeType = NodeType::findOrFail($id);

        $this->validateForm('Nodes\EditNodeTypeForm', $request);

        $nodeType->update($request->all());

        $this->notify('nodes.edited');

        return redirect()->route('reactor.nodes.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('ACCESS_NODES_DELETE');

        $nodeType = NodeType::findOrFail($id);

        $nodeType->delete();

        $this->notify('nodes.deleted');

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

        return view('nodes.fields', compact('nodeType'));
    }

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeTypeForm()
    {
        $form = $this->form('Nodes\CreateNodeTypeForm', [
            'url' => route('reactor.nodes.store')
        ]);

        return $form;
    }

    /**
     * @param $id
     * @param $nodeType
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeTypeForm($id, $nodeType)
    {
        $form = $this->form('Nodes\EditNodeTypeForm', [
            'url'    => route('reactor.nodes.update', $id),
            'model'  => $nodeType
        ]);

        return $form;
    }

}
