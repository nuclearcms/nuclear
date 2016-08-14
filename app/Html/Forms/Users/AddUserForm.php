<?php

namespace Reactor\Html\Forms\Users;


use Kris\LaravelFormBuilder\Form;

class AddUserForm extends Form {

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
        $this->add('user', 'select', [
            'rules' => 'required'
        ]);
    }

}