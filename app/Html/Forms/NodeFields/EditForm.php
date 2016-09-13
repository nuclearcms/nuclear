<?php


namespace Reactor\Html\Forms\NodeFields;


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
            'help_block' => ['text' => trans('hints.nodefields_label')]
        ]);
        $this->add('description', 'textarea');

        $this->add('position', 'number', [
            'default_value' => 0.8,
            'attr' => [
                'step' => 'any'
            ],
            'inline'  => true
        ]);

        $this->add('visible', 'checkbox', [
            'inline' => true,
            'default_value' => true
        ]);

        $this->add('rules', 'text', [
            'help_block' => ['text' => trans('hints.nodefields_rules')]
        ]);
        $this->add('default_value', 'textarea', [
            'help_block' => ['text' => trans('hints.nodefields_default_value')]
        ]);
        $this->add('options', 'textarea', [
            'help_block' => ['text' => trans('hints.nodefields_options')]
        ]);
    }
}