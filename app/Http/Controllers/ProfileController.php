<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\UsesProfileForms;
use Reactor\Http\Controllers\Traits\UsesProfileHelpers;
use Reactor\Http\Requests;

class ProfileController extends ReactorController {

    use UsesProfileForms, UsesProfileHelpers;

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $profile = $this->getProfile();

        $form = $this->getEditProfileForm($profile);

        return view('profile.edit', compact('form', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $this->validateUpdateProfile($request, $profile);

        $profile->update($request->all());

        $this->notify('users.edited', 'updated_own_information', $profile);

        return redirect()->route('reactor.profile.edit');
    }

    /**
     * Show the form for updating password.
     *
     * @return Response
     */
    public function password()
    {
        $profile = $this->getProfile();

        $form = $this->getPasswordForm();

        return view('profile.password', compact('form', 'profile'));
    }

    /**
     * Update users password
     *
     * @param Request $request
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $profile = $this->getProfile();

        $this->validateForm('Reactor\Http\Forms\Users\PasswordForm', $request);

        $profile->setPassword($request->input('password'))->save();

        $this->notify('users.changed_password', 'updated_own_password', $profile);

        return redirect()->route('reactor.profile.password');
    }

    /**
     * Shows the history for the user
     *
     * @return Response
     */
    public function history()
    {
        $profile = $this->getProfile();
        $activities = chronicle()->getUserActivity($profile->getKey(), 30);

        return view('profile.history')
            ->with(compact('profile', 'activities'));
    }

}
