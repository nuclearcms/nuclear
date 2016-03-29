<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\UsesSettingForms;
use Reactor\Http\Controllers\Traits\UsesSettingHelpers;
use Reactor\Http\Requests;

class SettingsController extends ReactorController {

    use UsesSettingForms, UsesSettingHelpers;

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
        $this->validateForm('Reactor\Http\Forms\Settings\CreateForm', $request);

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

        $this->validateForm('Reactor\Http\Forms\Settings\EditForm', $request);

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

}
