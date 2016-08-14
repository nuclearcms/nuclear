<?php

namespace Reactor\Html\Forms\Users;


use Kris\LaravelFormBuilder\Form;

class EditForm extends Form {

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
        $this->add('email', 'email', [
            'rules' => 'required|email|max:255|unique:users,email'
        ]);
        $this->add('first_name', 'text', [
            'rules' => 'required|max:50'
        ]);
        $this->add('last_name', 'text', [
            'rules' => 'required|max:50'
        ]);
    }
}