<?php

namespace Reactor\Html\Forms\NodeTypes;


use Kris\LaravelFormBuilder\Form;

class EditForm extends Form {

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
            'rules'      => 'required|max:255',
            'help_block' => ['text' => trans('hints.nodetype_label')]
        ]);
        $this->add('hides_children', 'checkbox', ['inline' => true]);
        $this->add('visible', 'checkbox', ['inline' => true, 'default_value' => true]);
        $this->add('taggable', 'checkbox', ['inline' => true]);
        $this->add('mailing', 'checkbox', [
            'inline' => true,
            'label'  => 'nodetypes.mailing_type'
        ]);
        $this->add('color', 'color', [
            'rules'  => 'required',
            'inline' => true,
            'default_value' => '#F1C40F'
        ]);
        $this->add('allowed_children', 'relation', [
            'search_route' => 'reactor.nodetypes.search.type.nodes',
            'getter_method' => 'get_nodetypes_by_ids',
            'default_value' => '[]',
            'mode' => 'multiple'
        ]);
    }

}