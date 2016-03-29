<?php

namespace Reactor\Http\Controllers\Traits;


use Reactor\Nodes\NodeType;

trait UsesNodeTypeForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateNodeTypeForm()
    {
        return $this->form('Reactor\Http\Forms\Nodes\CreateNodeTypeForm', [
            'url' => route('reactor.nodes.store')
        ]);
    }

    /**
     * @param int $id
     * @param NodeType $nodeType
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditNodeTypeForm($id, NodeType $nodeType)
    {
        return $this->form('Reactor\Http\Forms\Nodes\EditNodeTypeForm', [
            'url'   => route('reactor.nodes.update', $id),
            'model' => $nodeType
        ]);
    }

}