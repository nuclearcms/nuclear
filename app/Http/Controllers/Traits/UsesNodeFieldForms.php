<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\NodeField;

trait UsesNodeFieldForms {

    /**
     * @param int $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm($id)
    {
        return $this->form('Reactor\Html\Forms\NodeFields\CreateForm', [
            'url' => route('reactor.nodefields.store', $id)
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     */
    protected function validateCreateForm($id, Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\NodeFields\CreateForm', $request, [
            'name' => ['required', 'between:3,20', 'regex:/^([a-z_])+$/', 'not_reserved_name', 'unique:node_fields,name,NULL,id,node_type_id,' . $id]
        ]);
    }

    /**
     * @param int $id
     * @param NodeField $nodeField
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditForm($id, NodeField $nodeField)
    {
        return $this->form('Reactor\Html\Forms\NodeFields\EditForm', [
            'url'   => route('reactor.nodefields.update', $id),
            'model' => $nodeField
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateEditForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\NodeFields\EditForm', $request);
    }

}