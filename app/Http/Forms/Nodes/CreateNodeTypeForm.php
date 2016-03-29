<?php

namespace Reactor\Http\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class CreateNodeTypeForm extends Form {

    /**
     * Form options
     *
     * @var array
     */
    protected $formOptions = [
        'method' => 'POST'
    ];

    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules'      => ['required', 'between:3,20', 'regex:/^([a-z])+$/', 'unique:node_types'],
            'help_block' => ['text' => trans('hints.nodetype_name')]
        ]);
        $this->compose('Reactor\Http\Forms\Nodes\EditNodeTypeForm');
    }
}