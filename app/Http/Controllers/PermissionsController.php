<?php

namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\ACL\Permission;

class PermissionsController extends ReactorController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::sortable()->paginate();

        return view('permissions.index')
            ->with(compact('permissions'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $permissions = Permission::search($request->input('q'))->get();

        return view('permissions.search')
            ->with(compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form('Permissions\CreateEditForm', [
            'method' => 'POST',
            'url'    => '/reactor/permissions'
        ]);

        return view('permissions.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm('Permissions\CreateEditForm', $request);

        $permission = Permission::create($request->all());

        flash()->success(trans('users.created_permission'));

        return redirect('/reactor/permissions/' . $permission->getKey() . '/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        $form = $this->form('Permissions\CreateEditForm', [
            'method' => 'PUT',
            'url'    => '/reactor/permissions/' . $id,
            'model' => $permission
        ]);

        return view('permissions.edit', compact('form', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->validateForm('Permissions\CreateEditForm', $request, [
            'name' => ['required', 'max:255',
                'unique:permissions,name,' . $permission->getKey(),
                'regex:/^(ACCESS|WRITE)(_([A-Z]+))+$/']
        ]);

        $permission->update($request->all());

        flash()->success(trans('users.edited_permission'));

        return redirect('/reactor/permissions/' . $permission->getKey() . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        flash()->success(trans('users.deleted_permission'));

        return redirect('/reactor/permissions');
    }
}
