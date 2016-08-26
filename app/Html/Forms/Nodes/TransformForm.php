<?php


namespace Reactor\Html\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class TransformForm extends Form {

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
        $this->add('type', 'select', [
            'rules' => 'required',
            'inline' => true
        ]);
    }

}