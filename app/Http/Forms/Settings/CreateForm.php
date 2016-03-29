<?php

namespace Reactor\Http\Forms\Settings;


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
        $this->add('key', 'text', [
            'rules'      => 'required|max:25|alpha_dash|unique_setting',
            'help_block' => ['text' => trans('hints.settings_key')]
        ]);
        $this->compose('Reactor\Http\Forms\Settings\EditForm');
    }

}