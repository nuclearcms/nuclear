<?php


namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Nuclear\Hierarchy\Builders\BuilderService;
use Nuclear\Hierarchy\NodeField;
use Nuclear\Hierarchy\NodeType;
use Nuclear\Hierarchy\Repositories\NodeFieldRepository;
use Reactor\Http\Controllers\Traits\UsesNodeFieldForms;

class NodeFieldsController extends ReactorController {

    use UsesNodeFieldForms;

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('EDIT_NODETYPES');

        $nodetype = NodeType::findOrFail($id);
        $form = $this->getCreateForm($id);

        return $this->compileView('nodefields.create', compact('id', 'form', 'nodetype'));
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
        $this->authorize('EDIT_NODETYPES');

        $this->validateCreateForm($id, $request);

        $nodeField = $nodeFieldRepository->create($id, $request->all());

        $this->notify('nodefields.created', 'created_nodefield', $nodeField);

        return redirect()->route('reactor.nodefields.edit', $nodeField->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nodefield = NodeField::findOrFail($id);
        $nodetype = $nodefield->nodeType;

        $form = $this->getEditForm($id, $nodefield);

        return $this->compileView('nodefields.edit', compact('form', 'nodefield', 'nodetype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BuilderService $builderService
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BuilderService $builderService, Request $request, $id)
    {
        $this->authorize('EDIT_NODETYPES');

        $nodeField = NodeField::findOrFail($id);

        $this->validateEditForm($request);

        $nodeField->update($request->all());

        $builderService->buildForm($nodeField->nodeType);

        $this->notify('nodefields.edited');

        return redirect()->route('reactor.nodefields.edit', $id);
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
        $this->authorize('EDIT_NODEFIELDS');

        $nodeFieldRepository->destroy($id);

        $this->notify('nodefields.destroyed');

        return redirect()->back();
    }

}