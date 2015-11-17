<?php

namespace Reactor\Http\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class EditNodeTypeForm extends Form {

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
        $this->add('label', 'text', [
            'rules' => 'required|max:255',
            'help_block' => ['text' => trans('hints.nodetype_label')]
        ]);
        $this->add('description', 'textarea');
        $this->add('visible', 'checkbox');
        $this->add('hides_children', 'checkbox');
        $this->add('color', 'color', [
            'rules' => 'required',
            'default_value' => '#000000',
            'help_block' => ['text' => trans('hints.nodetype_color')]
        ]);
    }

}