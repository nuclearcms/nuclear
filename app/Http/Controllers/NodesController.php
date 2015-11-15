<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;

use Reactor\Http\Requests;
use Reactor\Nodes\Node;
use Reactor\Nodes\NodeType;

class NodesController extends ReactorController {

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int|null $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $this->authorize('ACCESS_CONTENTS_CREATE');

        $parent = ! is_null($id) ? Node::findOrFail($id) : null;

        $form = $this->getCreateNodeForm($id);

        return view('nodes.create', compact('form', 'parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int|null $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        $this->authorize('ACCESS_NODES_CREATE');

        $this->validateForm('Reactor\Http\Forms\Nodes\CreateNodeForm', $request);

        $node = $this->createNode($request, $id);

        $this->notify('nodes.created');

        return redirect()->route('reactor.contents.edit', $node->getKey());
    }

    /**
     * @param Request $request
     * @param $id
     * @return static
     */
    protected function createNode(Request $request, $id)
    {
        $node = new Node;
        $node->setNodeTypeByKey($request->input('type'));

        $node->fill([
            config('app.locale') => $request->all()
        ]);

        $node->save();

        return $this->locateNodeInTree($id, $node);
    }

    /**
     * @param $id
     * @param $node
     * @return mixed
     */
    protected function locateNodeInTree($id, $node)
    {
        if (is_null($id))
        {
            $node->makeRoot();

            return $node;
        }

        $parent = Node::findOrFail($id);
        $node->makeChildOf($parent);

        return $node;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $form = $this->getEditNodeForm($id, $node);

        return view('nodes.edit', compact('form', 'node'));
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
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $this->validateForm(
            'gen\\Forms\\' . source_form_name($node->nodeType->name),
            $request);

        $node->update([
            config('app.locale') => $request->all()
        ]);

        $this->notify('nodes.edited_type');

        return redirect()->route('reactor.contents.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param int|null $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeForm($id)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\CreateNodeForm', [
            'url' => route('reactor.contents.store', $id)
        ]);

        $nodeTypes = NodeType::all()
            ->lists('label', 'id')
            ->toArray();

        $form->modify('type', 'select', [
            'choices' => $nodeTypes
        ]);

        return $form;
    }

    /**
     * @param $id
     * @param $node
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeForm($id, $node)
    {
        $nodeType = $node->nodeType->name;
        $nodeTypeForm = 'gen\\Forms\\' . source_form_name($nodeType);

        $form = $this->form($nodeTypeForm, [
            'url'    => route('reactor.contents.update', $id),
            'model'  => $node
        ]);

        return $form;
    }
}
