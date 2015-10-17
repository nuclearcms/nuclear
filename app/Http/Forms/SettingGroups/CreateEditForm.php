<?php

namespace Reactor\Http\Forms\SettingGroups;


use Kris\LaravelFormBuilder\Form;

class CreateEditForm extends Form {

    public function buildForm()
    {
        $this->add('key', 'text', [
            'rules' => 'required|max:25|alpha_num|unique_setting_group',
            'help_block' => ['text' => trans('hints.settinggroup_key')]
        ]);
        $this->add('name', 'text', [
            'rules' => 'required|max:255',
            'help_block' => ['text' => trans('hints.settinggroup_name')]
        ]);
    }

}