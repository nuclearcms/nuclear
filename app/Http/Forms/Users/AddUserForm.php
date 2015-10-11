<?php

namespace Reactor\Http\Forms\Users;


use Kris\LaravelFormBuilder\Form;

class AddUserForm extends Form {

    public function buildForm()
    {
        $this->add('user', 'select', [
            'rules' => 'required'
        ]);
    }

}