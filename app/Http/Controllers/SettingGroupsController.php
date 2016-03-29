<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\UsesSettingGroupForms;
use Reactor\Http\Controllers\Traits\UsesSettingGroupHelpers;
use Reactor\Http\Requests;

class SettingGroupsController extends ReactorController {

    use UsesSettingGroupForms, UsesSettingGroupHelpers;

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

}
