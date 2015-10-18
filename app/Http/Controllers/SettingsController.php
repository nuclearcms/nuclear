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

        $form = $this->form('Settings\CreateForm', [
            'method' => 'POST',
            'url'    => route('reactor.settings.store')
        ]);

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

        settings()->set(
            $key = $request->input('key'),
            $request->input('value'),
            $request->input('type'),
            $request->input('group')
        );

        flash()->success(trans('settings.created'));

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

        if ( ! settings()->has($key))
        {
            abort(404);
        }

        $setting = settings()->getComplete($key);
        $setting['key'] = $key;

        $form = $this->form('Settings\EditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.settings.update', $key),
            'model'  => $setting
        ]);

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

        if ( ! settings()->has($key))
        {
            abort(404);
        }

        $this->validateForm('Settings\EditForm', $request);

        $setting = settings()->getComplete($key);

        settings()->set(
            $key,
            $setting['value'],
            $request->input('type'),
            $request->input('group')
        );

        flash()->success(trans('settings.edited'));

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

        if ( ! settings()->has($key))
        {
            abort(404);
        }

        settings()->delete($key);

        flash()->success(trans('settings.deleted'));

        return redirect()->route('reactor.settings.index');
    }

    /**
     * Show the form for editing settings in a group
     *
     * @param string|null $group
     * @return Response
     */
    public function editSettings($group = null)
    {
        $this->authorize('ACCESS_SETTINGS_MODIFY');

        if ( ! is_null($group) && ! settings()->hasGroup($group))
        {
            abort(404);
        }

        $settings = ($group) ? settings()->getGroupSettings($group) : settings()->settings();

        $form = $this->form('Settings\ModifyForm', [
            'method' => 'PUT',
            'url'    => route('reactor.settings.group.update', is_null($group) ? 'all' : $group),
            'model'  => $this->makeSettingsModel($settings)
        ], $settings);

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

        if ( $group !== 'all' && ! settings()->hasGroup($group))
        {
            abort(404);
        }

        $settings = ($group !== 'all') ? settings()->getGroupSettings($group) : settings()->settings();

        foreach ($settings as $key => $setting)
        {
            settings()->set($key, $request->input($key));
        }

        flash()->success(trans('settings.modified'));

        return redirect()->back();
    }

}
