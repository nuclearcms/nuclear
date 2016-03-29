<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait UsesSettingHelpers {

    /**
     * @param string $key
     * @return mixed
     */
    protected function findSettingOrFail($key)
    {
        if ( ! settings()->has($key))
        {
            abort(404);
        }

        $setting = settings()->getComplete($key);
        $setting['key'] = $key;

        return $setting;
    }

    /**
     * Prepares settings as model
     *
     * @param array $settings
     * @return array
     */
    protected function makeSettingsModel($settings)
    {
        return array_map(function ($setting)
        {
            return $setting['value'];
        }, $settings);
    }

    /**
     * @param Request $request
     * @return array|string
     */
    protected function setSetting(Request $request)
    {
        settings()->set(
            $key = $request->input('key'),
            $request->input('value'),
            $request->input('type'),
            $request->input('group')
        );

        return $key;
    }

    /**
     * @param Request $request
     * @param string $key
     * @param array $setting
     */
    protected function updateSetting(Request $request, $key, $setting)
    {
        settings()->set(
            $key,
            $setting['value'],
            $request->input('type'),
            $request->input('group')
        );
    }

    /**
     * @param string $group
     * @return mixed
     */
    protected function findSettingGroupOrFail($group)
    {
        if ($group !== 'all' && ! settings()->hasGroup($group))
        {
            abort(404);
        }

        return ($group !== 'all') ? settings()->getGroupSettings($group) : settings()->settings();
    }

    /**
     * @param Request $request
     * @param $settings
     */
    protected function modifySettings(Request $request, $settings)
    {
        foreach ($settings as $key => $setting)
        {
            settings()->set($key, $request->input($key));
        }
    }

}