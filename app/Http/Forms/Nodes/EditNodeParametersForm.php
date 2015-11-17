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
        $this->add('visible', 'checkbox');
        $this->add('sterile', 'checkbox');
        $this->add('home', 'checkbox');
        $this->add('locked', 'checkbox');
        $this->add('status', 'select', [
            'choices' => [
                30 => trans('nodes.draft'),
                40 => trans('nodes.pending'),
                50 => trans('nodes.published'),
                60 => trans('nodes.archived')
            ]
        ]);
        $this->add('published_at', 'date');
        $this->add('hides_children', 'checkbox');
        $this->add('priority', 'number');
        $this->add('children_order', 'select', [
            'choices' => [
                'title' => trans('validation.attributes.title'),
                'lft' => trans('nodes.position')
            ]
        ]);
        $this->add('children_order_direction', 'select', [
            'choices' => [
                'asc' => trans('nodes.ascending'),
                'desc' => trans('nodes.descending')
            ]
        ]);
    }

}