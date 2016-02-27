<?php

namespace Reactor\Http\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class EditNodeSEOForm extends Form {

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
        $this->add('meta_title', 'text', [
            'rules' => 'max:255'
        ]);
        $this->add('meta_keywords', 'text', [
            'rules' => 'max:255'
        ]);
        $this->add('meta_description', 'textarea');
        $this->add('meta_author', 'text');
        $this->add('meta_image', 'document');
    }

}