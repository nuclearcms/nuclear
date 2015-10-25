<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Requests;

class SettingsController extends ReactorController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = settings()->settings();

        return view('settings.index')
            ->with(compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('ACCESS_SETTINGS_CREATE');

        $form = $this->getCreateSettingForm();

        return view('settings.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm('Settings\CreateForm', $request);

        $key = $this->setSetting($request);

        $this->notify('settings.created');

        return redirect()->route('reactor.settings.edit', $key);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
        $this->authorize('ACCESS_SETTINGS_EDIT');

        $setting = $this->findSettingOrFail($key);

        $form = $this->getEditSettingsForm($key, $setting);

        return view('settings.edit', compact('form', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        $this->authorize('ACCESS_SETTINGS_EDIT');

        $setting = $this->findSettingOrFail($key);

        $this->validateForm('Settings\EditForm', $request);

        $this->updateSetting($request, $key, $setting);

        $this->notify('settings.edited');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function destroy($key)
    {
        $this->authorize('ACCESS_SETTINGS_DELETE');

        $this->findSettingOrFail($key);

        settings()->delete($key);

        $this->notify('settings.deleted');

        return redirect()->route('reactor.settings.index');
    }

    /**
     * Show the form for editing settings in a group
     *
     * @param string $group
     * @return Response
     */
    public function editSettings($group = 'all')
    {
        $this->authorize('ACCESS_SETTINGS_MODIFY');

        $settings = $this->findSettingGroupOrFail($group);

        $form = $this->getModifySettingsForm($group, $settings);

        return view('settings.modify', compact('settings', 'form', 'group'));
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
     * Update settings in a group
     *
     * @param Request $request
     * @param string|null $group
     * @return Response
     */
    public function updateSettings(Request $request, $group)
    {
        $this->authorize('ACCESS_SETTINGS_MODIFY');

        $settings = $this->findSettingGroupOrFail($group);

        $this->modifySettings($request, $settings);

        $this->notify('settings.modified');

        return redirect()->back();
    }

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateSettingForm()
    {
        $form = $this->form('Settings\CreateForm', [
            'url' => route('reactor.settings.store')
        ]);

        return $form;
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
     * @param $key
     * @param $setting
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditSettingsForm($key, $setting)
    {
        $form = $this->form('Settings\EditForm', [
            'url'   => route('reactor.settings.update', $key),
            'model' => $setting
        ]);

        return $form;
    }

    /**
     * @param $key
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
     * @param Request $request
     * @param $key
     * @param $setting
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
     * @param $group
     * @return mixed
     */
    protected function findSettingGroupOrFail($group)
    {
        if ( $group !== 'all' && ! settings()->hasGroup($group))
        {
            abort(404);
        }

        $settings = ($group !== 'all') ? settings()->getGroupSettings($group) : settings()->settings();

        return $settings;
    }

    /**
     * @param $group
     * @param $settings
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getModifySettingsForm($group, $settings)
    {
        $form = $this->form('Settings\ModifyForm', [
            'url'   => route('reactor.settings.group.update', is_null($group) ? 'all' : $group),
            'model' => $this->makeSettingsModel($settings)
        ], $settings);

        return $form;
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
