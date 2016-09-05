<?php


namespace Reactor\Html\Forms\Subscribers;


use Kris\LaravelFormBuilder\Form;

class CreateEditForm extends Form {

    public function buildForm()
    {
        $this->add('email', 'text', [
            'rules' => 'required|max:255|email|unique:subscribers'
        ]);
        $this->add('name', 'text', ['rules' => 'max:128']);

        $this->add('tel', 'text', ['inline' => true]);
        $this->add('tel_mobile', 'text', ['inline' => true]);
        $this->add('fax', 'text', ['inline' => true]);

        $this->add('address', 'textarea');
        $this->add('city', 'text', ['inline' => true]);
        $this->add('country', 'text', ['inline' => true]);
        $this->add('postal_code', 'text', ['inline' => true]);
        $this->add('nationality', 'text', ['inline' => true]);
        $this->add('national_id', 'text', ['inline' => true]);

        $this->add('additional', 'textarea');
    }

}