<?php

namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\ACL\Permission;
use Reactor\ACL\Role;
use Reactor\User;

class RolesController extends ReactorController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::sortable()->paginate();

        return view('roles.index')
            ->with(compact('roles'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $roles = Role::search($request->input('q'))->get();

        return view('roles.search')
            ->with(compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form('Roles\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.roles.store')
        ]);

        return view('roles.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm('Roles\CreateEditForm', $request);

        $role = Role::create($request->all());

        flash()->success(trans('users.created_role'));

        return redirect()->route('reactor.roles.edit', $role->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $form = $this->form('Roles\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.roles.update', $id),
            'model' => $role
        ]);

        return view('roles.edit', compact('form', 'role'));
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
        $role = Role::findOrFail($id);

        $this->validateForm('Roles\CreateEditForm', $request, [
            'name' => ['required', 'max:255',
                'unique:roles,name,' . $role->getKey(),
                'regex:/^([A-Z]+)$/']
        ]);

        $role->update($request->all());

        flash()->success(trans('users.edited_role'));

        return redirect()->route('reactor.roles.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        flash()->success(trans('users.deleted_role'));

        return redirect()->route('reactor.roles.index');
    }

    /**
     * List the specified resource permissions.
     *
     * @param int $id
     * @return Response
     */
    public function permissions($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        return view('roles.permissions')
            ->with(compact('role', 'permissions'));
    }

    /**
     * Add a permission to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function addPermission(Request $request, $id)
    {

    }

    /**
     * Remove a permission from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function removePermission(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->revokePermission($request->input('permission'));

        flash()->success(trans('users.unlinked_permission'));

        return redirect()->route('reactor.roles.permissions', $id);
    }

    /**
     * List the specified resource users.
     *
     * @param int $id
     * @return Response
     */
    public function users($id)
    {
        $role = Role::with('users')->findOrFail($id);
        $users = User::all();

        return view('roles.users')
            ->with(compact('role', 'users'));
    }

    /**
     * Remove an user from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function removeUser(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->dissociateUser($request->input('user'));

        flash()->success(trans('users.unlinked_user'));

        return redirect()->route('reactor.roles.users', $id);
    }

}
