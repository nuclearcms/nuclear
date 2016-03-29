<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Reactor\Nodes\NodeField;

trait UsesNodeFieldForms {

    /**
     * @param int $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeFieldForm($id)
    {
        return $this->form('Reactor\Http\Forms\Nodes\CreateNodeFieldForm', [
            'url' => route('reactor.nodes.field.store', $id)
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     */
    protected function validateCreateNodeFieldForm($id, Request $request)
    {
        $this->validateForm('Reactor\Http\Forms\Nodes\CreateNodeFieldForm', $request, [
            'name' => ['required', 'between:3,20', 'regex:/^([a-z_])+$/', 'not_reserved_field', 'unique:node_fields,name,NULL,id,node_type_id,' . $id]
        ]);
    }

    /**
     * @param int $id
     * @param NodeField $nodeField
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeFieldForm($id, NodeField $nodeField)
    {
        return $this->form('Reactor\Http\Forms\Nodes\EditNodeFieldForm', [
            'url'   => route('reactor.nodes.field.update', $id),
            'model' => $nodeField
        ]);
    }

}