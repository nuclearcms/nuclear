<?php

namespace Reactor\Http\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class CreateNodeFieldForm extends Form {

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
            'rules' => ['required', 'between:3,20', 'regex:/^([a-z_])+$/'],
            'help_block' => ['text' => trans('hints.nodefield_name')]
        ]);
        $this->add('type', 'select', [
            'rules' => 'required',
            'choices' => $this->getFieldTypes(),
            'inline' => true
        ]);
        $this->add('position', 'number', [
            'default_value' => 0.8,
            'attr' => [
                'step' => 'any'
            ],
            'inline' => true
        ]);

        $this->compose('Reactor\Http\Forms\Nodes\EditNodeFieldForm');

        $this->add('rules', 'textarea');
        $this->add('default_value', 'textarea');
        $this->add('options', 'textarea');
    }

    /**
     * Returns the available types
     *
     * @return array
     */
    protected function getFieldTypes()
    {
        $types = config('hierarchy.type_map', [
            'text'     => 'string',
            'textarea' => 'text',
            'markdown' => 'longtext',
            'file'     => 'unsignedInteger',
            'gallery'  => 'text',
            'checkbox' => 'boolean',
            'select'   => 'string',
            'number'   => 'double',
            'color'    => 'string',
            'slug'     => 'string',
            'tag'      => 'text',
            'password' => 'string'
        ]);

        foreach($types as $key => $type)
        {
            $types[$key] = trans('nodes.type_' . $key);
        }

        return $types;
    }

}