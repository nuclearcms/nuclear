<?php

namespace Reactor\Http\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class ImageForm extends Form {

    public function buildForm()
    {
        $this->add('action', 'hidden', [
            'rules' => ['required', 'regex:/^(crop_[0-9]+,[0-9]+,[0-9]+,[0-9]+|rotate_(90|270)|flip_(h|v))$/']
        ]);
    }

}