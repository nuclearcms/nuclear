<?php


namespace Reactor\Html\Forms\Permissions;


use Kris\LaravelFormBuilder\Form;

class AddPermissionForm extends Form {

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
        $this->add('permission', 'select', [
            'rules' => 'required',
            'label' => 'permissions.self'
        ]);
    }

}