<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Reactor\ACL\Permission;

trait UsesPermissionForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreatePermissionForm()
    {
        return $this->form('Reactor\Http\Forms\Permissions\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.permissions.store')
        ]);
    }

    /**
     * @param $id
     * @param Permission $permission
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditPermissionForm($id, Permission $permission)
    {
        return $this->form('Reactor\Http\Forms\Permissions\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.permissions.update', $id),
            'model'  => $permission
        ]);
    }

    /**
     * @param Request $request
     * @param Permission $permission
     */
    protected function validateUpdatePermission(Request $request, Permission $permission)
    {
        $this->validateForm('Reactor\Http\Forms\Permissions\CreateEditForm', $request, [
            'name' => ['required', 'max:255',
                'unique:permissions,name,' . $permission->getKey(),
                'regex:/^(ACCESS|WRITE|SITE|REACTOR)(_([A-Z]+))+$/']
        ]);
    }

}