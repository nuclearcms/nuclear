<?php namespace Reactor\Http\Forms\Users;

use Kris\LaravelFormBuilder\Form;

class EditForm extends Form
{

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
            'rules' => 'required|email|unique:users,email'
        ]);
        $this->add('first_name', 'text', [
            'label' => 'users.first_name',
            'rules' => 'required|max:50'
        ]);
        $this->add('last_name', 'text', [
            'label' => 'users.last_name',
            'rules' => 'required|max:50'
        ]);
    }
}