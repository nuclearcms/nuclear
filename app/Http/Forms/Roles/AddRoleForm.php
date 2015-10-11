<?php

namespace Reactor\Http\Forms\Roles;


use Kris\LaravelFormBuilder\Form;

class AddRoleForm extends Form {

    public function buildForm()
    {
        $this->add('role', 'select', [
            'rules' => 'required'
        ]);
    }

}