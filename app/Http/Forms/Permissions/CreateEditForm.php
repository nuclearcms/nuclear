<?php

namespace Reactor\Http\Forms\Permissions;


use Kris\LaravelFormBuilder\Form;

class CreateEditForm extends Form {

    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => ['required', 'max:255', 'unique:permissions,name', 'regex:/^(ACCESS|WRITE|SITE|REACTOR)(_([A-Z]+))+$/'],
            'help_block' => ['text' => trans('hints.permission_name')]
        ]);
    }

}