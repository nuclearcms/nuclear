<?php

namespace Reactor\Http\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class EditNodeFieldForm extends Form {

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
            'help_block' => ['text' => trans('hints.nodefield_label')]
        ]);
        $this->add('description', 'textarea');
        $this->add('position', 'number', [
            'default_value' => 0.8,
            'attr' => [
                'step' => 'any'
            ]
        ]);
    }

}