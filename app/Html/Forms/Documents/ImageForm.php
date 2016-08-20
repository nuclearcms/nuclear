<?php

namespace Reactor\Html\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class ImageForm extends Form {

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
        $this->add('action', 'hidden', [
            'rules' => ['required', 'regex:/^(crop_[0-9]+,[0-9]+,[0-9]+,[0-9]+|rotate_(90|270)|flip_(h|v)|greyscale|sharpen_10|blur_10)$/']
        ]);
    }

}