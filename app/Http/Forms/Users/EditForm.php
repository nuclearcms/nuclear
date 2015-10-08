<?php namespace Reactor\Http\Forms\Users;

use Kris\LaravelFormBuilder\Form;

class EditForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('email', 'email')
            ->add('first_name', 'text', [
                'label' => 'users.first_name',
                'rules' => 'required|max:50'
            ])
            ->add('last_name', 'text', [
                'label' => 'users.last_name',
                'rules' => 'required|max:50'
            ]);
    }
}