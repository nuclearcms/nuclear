<?php

namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Nuclear\Hierarchy\Repositories\NodeFieldRepository;
use Reactor\Http\Requests;
use Reactor\Nodes\NodeField;
use Reactor\Nodes\NodeType;

class NodeFieldsController extends ReactorController
{
    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $nodeType = NodeType::findOrFail($id);

        $form = $this->getCreateNodeFieldForm($id);

        return view('nodefields.create', compact('form', 'nodeType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @param NodeFieldRepository $nodeFieldRepository
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, NodeFieldRepository $nodeFieldRepository, Request $request)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $this->validateForm('Reactor\Http\Forms\Nodes\CreateNodeFieldForm', $request);

        $nodeField = $nodeFieldRepository->create($id, $request->all());

        $this->notify('nodes.created_field');

        return redirect()->route('reactor.nodes.field.edit', $nodeField->getKey());
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

        $nodeField = NodeField::findOrFail($id);

        $form = $this->getEditNodeFieldForm($id, $nodeField);

        return view('nodefields.edit', compact('form', 'nodeField', 'nodeType'));
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

        $nodeField = NodeField::findOrFail($id);

        $this->validateForm('Reactor\Http\Forms\Nodes\EditNodeFieldForm', $request);

        $nodeField->update($request->all());

        $this->notify('nodes.edited_field');

        return redirect()->route('reactor.nodes.field.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NodeFieldRepository $nodeFieldRepository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NodeFieldRepository $nodeFieldRepository, $id)
    {
        $this->authorize('ACCESS_NODES_EDIT');

        $nodeFieldRepository->destroy($id);

        $this->notify('nodes.deleted_field');

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeFieldForm($id)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\CreateNodeFieldForm', [
            'url' => route('reactor.nodes.field.store', $id)
        ]);

        return $form;
    }

    /**
     * @param $id
     * @param NodeField $nodeField
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeFieldForm($id, NodeField $nodeField)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\EditNodeFieldForm', [
            'url'    => route('reactor.nodes.field.update', $id),
            'model'  => $nodeField
        ]);

        return $form;
    }
}
