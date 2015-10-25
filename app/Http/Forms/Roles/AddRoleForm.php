<?php

namespace Reactor\Http\Forms\Roles;


use Kris\LaravelFormBuilder\Form;

class AddRoleForm extends Form {

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
        $this->add('role', 'select', [
            'rules' => 'required'
        ]);
    }

}