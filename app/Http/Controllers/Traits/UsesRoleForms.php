<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Users\Role;
use Nuclear\Users\User;

trait UsesRoleForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateForm()
    {
        return $this->form('Reactor\Html\Forms\Roles\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.roles.store')
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateCreateForm(Request $request)
    {
        $this->validateForm('Reactor\Html\Forms\Roles\CreateEditForm', $request);
    }

    /**
     * @param int $id
     * @param Role $role
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditForm($id, Role $role)
    {
        return $this->form('Reactor\Html\Forms\Roles\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.roles.update', $id),
            'model'  => $role
        ]);
    }

    /**
     * @param Request $request
     * @param Role $role
     */
    protected function validateEditForm(Request $request, Role $role)
    {
        $this->validateForm('Reactor\Html\Forms\Roles\CreateEditForm', $request, [
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
        $form = $this->form('Reactor\Html\Forms\Users\AddUserForm', [
            'url' => route('reactor.roles.users.associate', $id)
        ]);

        $choices = User::all()
            ->diff($role->users)
            ->pluck('first_name', 'id')
            ->toArray();

        $form->modify('user', 'select', [
            'choices' => $choices
        ]);

        return [$form, count($choices)];
    }

}