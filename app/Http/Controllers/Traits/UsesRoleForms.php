<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Reactor\ACL\Role;
use Reactor\User;

trait UsesRoleForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateRoleForm()
    {
        return $this->form('Reactor\Http\Forms\Roles\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.roles.store')
        ]);
    }

    /**
     * @param int $id
     * @param Role $role
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditRoleForm($id, Role $role)
    {
        return $this->form('Reactor\Http\Forms\Roles\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.roles.update', $id),
            'model'  => $role
        ]);
    }

    /**
     * @param Request $request
     * @param Role $role
     */
    protected function validateUpdateRole(Request $request, Role $role)
    {
        $this->validateForm('Reactor\Http\Forms\Roles\CreateEditForm', $request, [
            'name' => ['required', 'max:255',
                'unique:roles,name,' . $role->getKey(),
                'regex:/^([A-Z]+)$/']
        ]);
    }

    /**
     * Creates a form for adding permissions
     *
     * @param int $id
     * @param Role $role
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getAddUserForm($id, Role $role)
    {
        $form = $this->form('Reactor\Http\Forms\Users\AddUserForm', [
            'url' => route('reactor.roles.user.add', $id)
        ]);

        $choices = User::all()
            ->diff($role->users)
            ->lists('first_name', 'id')
            ->toArray();

        $form->modify('user', 'select', [
            'choices' => $choices
        ]);

        return $form;
    }

}