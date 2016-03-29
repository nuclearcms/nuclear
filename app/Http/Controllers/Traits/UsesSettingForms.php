<?php

namespace Reactor\Http\Controllers\Traits;


trait UsesSettingForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateSettingForm()
    {
        return $this->form('Reactor\Http\Forms\Settings\CreateForm', [
            'url' => route('reactor.settings.store')
        ]);
    }

    /**
     * @param string $key
     * @param array $setting
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditSettingsForm($key, array $setting)
    {
        return $this->form('Reactor\Http\Forms\Settings\EditForm', [
            'url'   => route('reactor.settings.update', $key),
            'model' => $setting
        ]);
    }

    /**
     * @param string $group
     * @param array $settings
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getModifySettingsForm($group, array $settings)
    {
        return $this->form('Reactor\Http\Forms\Settings\ModifyForm', [
            'url'   => route('reactor.settings.group.update', is_null($group) ? 'all' : $group),
            'model' => $this->makeSettingsModel($settings)
        ], $settings);
    }

}