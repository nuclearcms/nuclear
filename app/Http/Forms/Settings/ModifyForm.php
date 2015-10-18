<?php

namespace Reactor\Http\Forms\Settings;


use Kris\LaravelFormBuilder\Form;

class ModifyForm extends Form {

    public function buildForm()
    {
        foreach ($this->data as $key => $setting)
        {
            $this->add($key, $setting['type']);
        }
    }

}