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
        $groups = settings()->groups();

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

        $form = $this->form('SettingGroups\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.settinggroups.store')
        ]);

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
        $this->validateForm('SettingGroups\CreateEditForm', $request);

        settings()->setGroup(
            $key = $request->input('key'),
            $request->input('name')
        );

        flash()->success(trans('settings.created_group'));

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

        if ( ! settings()->hasGroup($key))
        {
            abort(404);
        }

        $name = settings()->getGroup($key);

        $form = $this->form('SettingGroups\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.settinggroups.update', $key),
            'model'  => compact('key', 'name')
        ]);

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

        if ( ! settings()->hasGroup($key))
        {
            abort(404);
        }

        $this->validateForm('SettingGroups\CreateEditForm', $request, [
            'key' => 'required|max:25|alpha_num|unique_setting_group:' . $key
        ]);

        settings()->setGroup($key, $request->input('name'));

        flash()->success(trans('settings.edited_group'));

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

        if ( ! settings()->hasGroup($key))
        {
            abort(404);
        }

        settings()->deleteGroup($key);

        flash()->success(trans('settings.deleted_group'));

        return redirect()->route('reactor.settinggroups.index');
    }
}
