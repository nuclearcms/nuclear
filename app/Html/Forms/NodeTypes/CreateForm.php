<?php

namespace Reactor\Html\Forms\NodeTypes;


use Kris\LaravelFormBuilder\Form;

class CreateForm extends Form {

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
        $this->compose('Reactor\Html\Forms\NodeTypes\EditForm');
    }
}