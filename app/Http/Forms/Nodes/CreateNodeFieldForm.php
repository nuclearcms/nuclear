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
            'rules'      => ['required', 'between:3,20', 'regex:/^([a-z_])+$/', 'not_reserved_field'],
            'help_block' => ['text' => trans('hints.nodefield_name')]
        ]);
        $this->add('type', 'select', [
            'rules'   => 'required',
            'choices' => $this->getFieldTypes(),
            'inline'  => true
        ]);

        $this->compose('Reactor\Http\Forms\Nodes\EditNodeFieldForm');
    }

    /**
     * Returns the available types
     *
     * @return array
     */
    protected function getFieldTypes()
    {
        $types = config('hierarchy.type_map', [
            'text'            => 'string',
            'textarea'        => 'text',
            'markdown'        => 'longtext',
            'document'        => 'unsignedInteger',
            'gallery'         => 'text',
            'checkbox'        => 'boolean',
            'select'          => 'string',
            'number'          => 'double',
            'color'           => 'string',
            'slug'            => 'string',
            'tag'             => 'text',
            'password'        => 'string',
            'date'            => 'timestamp',
            'node_collection' => 'text',
            'node'            => 'integer'
        ]);

        foreach ($types as $key => $type)
        {
            $types[$key] = trans('nodes.type_' . $key);
        }

        return $types;
    }

}