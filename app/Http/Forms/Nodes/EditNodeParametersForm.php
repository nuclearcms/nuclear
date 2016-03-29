<?php

namespace Reactor\Http\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class EditNodeParametersForm extends Form {

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
        $this->add('visible', 'checkbox', ['inline' => true]);
        $this->add('locked', 'checkbox', ['inline' => true]);
        $this->add('sterile', 'checkbox', ['inline' => true]);
        $this->add('home', 'checkbox', ['inline' => true]);
        $this->add('hides_children', 'checkbox', ['inline' => true]);
        $this->add('priority', 'number', [
            'default_value' => 1,
            'attr'          => [
                'step' => 'any'
            ],
            'inline'        => true
        ]);
        $this->add('status', 'select', [
            'choices' => [
                30 => trans('nodes.draft'),
                40 => trans('nodes.pending'),
                50 => trans('nodes.published'),
                60 => trans('nodes.archived')
            ],
            'inline'  => true
        ]);
        $this->add('published_at', 'date', [
            'rules' => 'date_mysql'
        ]);
        $this->add('children_order', 'select', [
            'choices' => [
                'title'        => trans('validation.attributes.title'),
                'created_at'   => trans('validation.attributes.created_at'),
                'published_at' => trans('validation.attributes.published_at'),
                'updated_at'   => trans('validation.attributes.updated_at'),
                '_lft'         => trans('nodes.position')
            ],
            'inline'  => true
        ]);
        $this->add('children_order_direction', 'select', [
            'choices' => [
                'asc'  => trans('nodes.ascending'),
                'desc' => trans('nodes.descending')
            ],
            'inline'  => true
        ]);
        $this->add('children_display_mode', 'select', [
            'choices' => [
                'tree' => trans('nodes.tree_display'),
                'list' => trans('nodes.list_display')
            ],
            'inline'  => true,
            'rules'   => 'in:tree,list'
        ]);
    }

}