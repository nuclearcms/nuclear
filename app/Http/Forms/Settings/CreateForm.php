<?php

namespace Reactor\Http\Forms\Settings;


use Kris\LaravelFormBuilder\Form;

class CreateForm extends Form {

    public function buildForm()
    {
        $this->add('key', 'text', [
            'rules' => 'required|max:25|alpha_dash|unique_setting',
            'help_block' => ['text' => trans('hints.settings_key')]
        ]);
        $this->add('type', 'select', [
            'choices' => settings()->getAvailableTypes()
        ]);
        $this->add('group', 'select', [
            'choices' => settings()->getGroups(),
            'empty_value' => '------------'
        ]);
    }

}