<?php

namespace Reactor\Http\Forms\Settings;


use Kris\LaravelFormBuilder\Form;

class EditForm extends Form {

    public function buildForm()
    {
        $this->add('type', 'select', [
            'choices' => settings()->getAvailableTypes()
        ]);
        $this->add('group', 'select', [
            'choices' => settings()->getGroups(),
            'empty_value' => '------------'
        ]);
    }

}