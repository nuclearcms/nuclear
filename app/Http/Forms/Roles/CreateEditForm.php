<?php

namespace Reactor\Http\Forms\Roles;


use Kris\LaravelFormBuilder\Form;

class CreateEditForm extends Form {

    public function buildForm()
    {
        $this->add('label', 'text', [
            'rules' => 'required|max:255',
            'help_block' => ['text' => trans('hints.role_label')]
        ]);
        $this->add('name', 'text', [
            'rules' => ['required', 'max:255', 'unique:roles,name', 'regex:/^([A-Z]+)$/'],
            'help_block' => ['text' => trans('hints.role_name')]
        ]);
    }

}