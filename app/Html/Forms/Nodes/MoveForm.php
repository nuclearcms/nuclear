<?php


namespace Reactor\Html\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class MoveForm extends Form {

    /**
     * Form options
     *
     * @var array
     */
    protected $formOptions = [
        'method' => 'PUT'
    ];

    public function buildForm()
    {
        $this->add('parent', 'node', [
            'rules' => 'required',
            'label' => trans('nodes.parent'),
            'help_block' => ['text' => trans('hints.nodes_parent')]
        ]);
    }

}