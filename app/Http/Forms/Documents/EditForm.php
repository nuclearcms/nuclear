<?php

namespace Reactor\Http\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class EditForm extends Form {

    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => 'required|max:255'
        ]);
        $this->add('public_url', 'text', [
            'attr' => ['disabled']
        ]);
    }

}