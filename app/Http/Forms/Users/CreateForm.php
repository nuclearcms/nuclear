<?php namespace Reactor\Http\Forms\Users;

use Kris\LaravelFormBuilder\Form;

class CreateForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('email', 'email', [
                'rules' => 'required|email|unique:users,email'
            ])
            ->add('password', 'password', [
                'rules' => 'required|min:8',
                'meter' => true
            ])
            ->add('password_confirmation', 'password', [
                'rules' => 'required|min:8|same:password'
            ])
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