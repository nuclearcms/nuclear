<?php

namespace Reactor\Html\Forms\Users;


use Kris\LaravelFormBuilder\Form;

class CreateForm extends Form {

    /**
     * Form options
     *
     * @var array
     */
    protected $formOptions = [
        'method' => 'POST'
    ];

    public function buildForm()
    {
        $this->compose('Reactor\Html\Forms\Users\EditForm');
        $this->compose('Reactor\Html\Forms\Users\PasswordForm');
    }

}