<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait UsesSettingGroupForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateSettingGroupForm()
    {
        return $this->form('Reactor\Http\Forms\SettingGroups\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.settinggroups.store')
        ]);
    }

    /**
     * @param string $key
     * @param string $name
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditSettingGroupForm($key, $name)
    {
        return $this->form('Reactor\Http\Forms\SettingGroups\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.settinggroups.update', $key),
            'model'  => compact('key', 'name')
        ]);
    }

    /**
     * @param Request $request
     * @param string $key
     */
    protected function validateUpdateGroup(Request $request, $key)
    {
        $this->validateForm('Reactor\Http\Forms\SettingGroups\CreateEditForm', $request, [
            'key' => 'required|max:25|alpha_dash|unique_setting_group:' . $key
        ]);
    }

}