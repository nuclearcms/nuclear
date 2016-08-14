<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Users\Role;
use Nuclear\Users\User;

trait UsesUserForms {

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateUserForm()
    {
        return $this->form('Reactor\Html\Forms\Users\CreateForm', [
            'url' => route('reactor.users.store')
        ]);
    }

    /**
     * @param int $id
     * @param User $profile
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditUserForm($id, User $profile)
    {
        return $this->form('Reactor\Html\Forms\Users\EditForm', [
            'url'   => route('reactor.users.update', $id),
            'model' => $profile
        ]);
    }

    /**
     * @param Request $request
     * @param User $profile
     */
    protected function validateEditUserForm(Request $request, User $profile)
    {
        $this->validateForm('Reactor\Html\Forms\Users\EditForm', $request, [
            'email' => 'required|email|max:255|unique:users,email,' . $profile->getKey()
        ]);
    }

    /**
     * @param int $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getPasswordForm($id)
    {
        return $this->form('Reactor\Html\Forms\Users\PasswordForm', [
            'url' => route('reactor.users.password.post', $id),
        ]);
    }

    /**
     * Creates a form for adding permissions
     *
     * @param int $id
     * @param User $user
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getAddRoleForm($id, User $user)
    {
        $form = $this->form('Reactor\Html\Forms\Roles\AddRoleForm', [
            'url' => route('reactor.users.roles.add', $id)
        ]);

        $choices = Role::all()
            ->diff($user->roles)
            ->pluck('label', 'id')
            ->toArray();

        $form->modify('role', 'select', [
            'choices' => $choices
        ]);

        return $form;
    }

}