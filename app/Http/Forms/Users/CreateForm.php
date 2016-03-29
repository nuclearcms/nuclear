<?php namespace Reactor\Http\Forms\Users;


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
        $this->compose('Reactor\Http\Forms\Users\EditForm');
        $this->compose('Reactor\Http\Forms\Users\PasswordForm');
    }
}