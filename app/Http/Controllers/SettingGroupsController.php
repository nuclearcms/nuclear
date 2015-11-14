<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Requests;

class SettingGroupsController extends ReactorController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = settings()->getGroups();

        return view('settinggroups.index')
            ->with(compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('ACCESS_SETTINGGROUPS_CREATE');

        $form = $this->getCreateSettingGroupForm();

        return view('settinggroups.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm('Reactor\Http\Forms\SettingGroups\CreateEditForm', $request);

        $key = $this->setGroup($request);

        $this->notify('settings.created_group');

        return redirect()->route('reactor.settinggroups.edit', $key);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $key
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
        $this->authorize('ACCESS_SETTINGGROUPS_EDIT');

        $name = $this->findSettingGroupOrFail($key);

        $form = $this->getEditSettingGroupForm($key, $name);

        return view('settinggroups.edit', compact('form', 'name'));
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
        $this->authorize('ACCESS_SETTINGGROUPS_EDIT');

        $this->findSettingGroupOrFail($key);

        $this->validateUpdateGroup($request, $key);

        $this->updateGroup($request, $key);

        $this->notify('settings.edited_group');

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
        $this->authorize('ACCESS_SETTINGGROUPS_DELETE');

        $this->findSettingGroupOrFail($key);

        settings()->deleteGroup($key);

        $this->notify('settings.deleted_group');

        return redirect()->route('reactor.settinggroups.index');
    }

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateSettingGroupForm()
    {
        $form = $this->form('Reactor\Http\Forms\SettingGroups\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.settinggroups.store')
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    protected function setGroup(Request $request)
    {
        settings()->setGroup(
            $key = $request->input('key'),
            $request->input('name')
        );

        return $key;
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function findSettingGroupOrFail($key)
    {
        if ( ! settings()->hasGroup($key))
        {
            abort(404);
        }

        $name = settings()->getGroup($key);

        return $name;
    }

    /**
     * @param $key
     * @param $name
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditSettingGroupForm($key, $name)
    {
        $form = $this->form('Reactor\Http\Forms\SettingGroups\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.settinggroups.update', $key),
            'model'  => compact('key', 'name')
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @param $key
     */
    protected function updateGroup(Request $request, $key)
    {
        settings()->setGroup($key, $request->input('name'));
    }

    /**
     * @param Request $request
     * @param $key
     */
    protected function validateUpdateGroup(Request $request, $key)
    {
        $this->validateForm('Reactor\Http\Forms\SettingGroups\CreateEditForm', $request, [
            'key' => 'required|max:25|alpha_dash|unique_setting_group:' . $key
        ]);
    }
}
