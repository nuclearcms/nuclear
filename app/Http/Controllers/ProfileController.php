<?php

namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\Http\Requests;

class ProfileController extends ReactorController
{
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
     * Returns the currently logged in user
     *
     * @return User
     */
    protected function getProfile()
    {
        return auth()->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $this->validateUpdateProfile($request, $profile);

        $profile->update($request->all());

        $this->notify('users.edited');

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

        $this->notify('users.changed_password');

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

    /**
     * @param $profile
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditProfileForm($profile)
    {
        $form = $this->form('Reactor\Http\Forms\Users\EditForm', [
            'url'   => route('reactor.profile.update'),
            'model' => $profile
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @param $profile
     */
    protected function validateUpdateProfile(Request $request, $profile)
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
        $form = $this->form('Reactor\Http\Forms\Users\PasswordForm', [
            'url' => route('reactor.profile.password.post'),
        ]);

        return $form;
    }

}
