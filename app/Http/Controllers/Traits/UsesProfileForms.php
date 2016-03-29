<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Reactor\User;

trait UsesProfileForms {

    /**
     * @param User $profile
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditProfileForm(User $profile)
    {
        return $this->form('Reactor\Http\Forms\Users\EditForm', [
            'url'   => route('reactor.profile.update'),
            'model' => $profile
        ]);
    }

    /**
     * @param Request $request
     * @param User $profile
     */
    protected function validateUpdateProfile(Request $request, User $profile)
    {
        $this->validateForm('Reactor\Http\Forms\Users\EditForm', $request, [
            'email' => 'required|email|unique:users,email,' . $profile->getKey()
        ]);
    }

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getPasswordForm()
    {
        return $this->form('Reactor\Http\Forms\Users\PasswordForm', [
            'url' => route('reactor.profile.password.post'),
        ]);
    }

}