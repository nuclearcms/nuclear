<?php namespace Reactor\Http\Forms\Users;

use Kris\LaravelFormBuilder\Form;

class PasswordForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('password', 'password', [
                'rules' => 'required|min:8',
                'meter' => true
            ])
            ->add('password_confirmation', 'password', [
                'rules' => 'required|min:8|same:password'
            ]);
    }
}