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

        $this->validateUpdateNodeForm($request, $node);

        $node->update([
            config('app.locale') => $request->all()
        ]);

        $this->notify('nodes.edited');

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
     * Show the form for editing the specified resources seo params.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function seo($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $form = $this->getEditNodeSEOForm($id, $node);

        return view('nodes.seo', compact('form', 'node'));
    }

    /**
     * Update the specified resources seo params in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateSEO(Request $request, $id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $this->validateForm('Reactor\Http\Forms\Nodes\EditNodeSEOForm', $request);

        $node->update([
            config('app.locale') => $request->all()
        ]);

        $this->notify('nodes.edited');

        return redirect()->route('reactor.contents.seo', $id);
    }

    /**
     * Show the form for editing the specified resources parameters.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function parameters($id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $form = $this->getEditNodeParametersForm($id, $node);

        return view('nodes.parameters', compact('form', 'node'));
    }

    /**
     * Update the specified resources paramaters in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateParameters(Request $request, $id)
    {
        $this->authorize('ACCESS_CONTENTS_EDIT');

        $node = Node::findOrFail($id);

        $this->validateForm('Reactor\Http\Forms\Nodes\EditNodeParametersForm', $request);

        $node->update($request->all());

        if ($request->input('home') === '1')
        {
            $home = Node::whereHome(1)->first();
            $home->update(['home' => 0]);
        }

        $this->notify('nodes.edited');

        return redirect()->route('reactor.contents.parameters', $id);
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
            'url'   => route('reactor.contents.update', $id),
            'model' => $node
        ]);

        return $form;
    }

    /**
     * @param $id
     * @param $node
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeSEOForm($id, $node)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\EditNodeSEOForm', [
            'url'   => route('reactor.contents.seo.update', $id),
            'model' => $node
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @param $node
     */
    protected function validateUpdateNodeForm(Request $request, $node)
    {
        $this->validateForm(
            'gen\\Forms\\' . source_form_name($node->nodeType->name),
            $request, [
            'node_name' => 'max:255|alpha_dash|unique:node_sources,node_name,' . $node->getKey()
        ]);
    }

    /**
     * @param $id
     * @param $node
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeParametersForm($id, $node)
    {
        $form = $this->form('Reactor\Http\Forms\Nodes\EditNodeParametersForm', [
            'url'   => route('reactor.contents.parameters.update', $id),
            'model' => $node
        ]);

        return $form;
    }
}
