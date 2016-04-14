<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\ACL\Permission;
use Reactor\Http\Controllers\Traits\UsesPermissionForms;

class PermissionsController extends ReactorController {

    use UsesPermissionForms;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::sortable()->paginate();

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $permissions = Permission::search($request->input('q'), 20, true)->get();

        return view('permissions.search', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('ACCESS_PERMISSIONS_CREATE');

        $form = $this->getCreatePermissionForm();

        return view('permissions.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('ACCESS_PERMISSIONS_CREATE');

        $this->validateForm('Reactor\Http\Forms\Permissions\CreateEditForm', $request);

        $permission = Permission::create($request->all());

        $this->notify('users.created_permission');

        return redirect()->route('reactor.permissions.edit', $permission->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('ACCESS_PERMISSIONS_EDIT');

        $permission = Permission::findOrFail($id);

        $form = $this->getEditPermissionForm($id, $permission);

        return view('permissions.edit', compact('form', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('ACCESS_PERMISSIONS_EDIT');

        $permission = Permission::findOrFail($id);

        $this->validateUpdatePermission($request, $permission);

        $permission->update($request->all());

        $this->notify('users.edited_permission');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('ACCESS_PERMISSIONS_DELETE');

        $permission = Permission::findOrFail($id);

        $permission->delete();

        $this->notify('users.deleted_permission');

        return redirect()->route('reactor.permissions.index');
    }

}
