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

        $form = $this->form('Users\EditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.profile.update'),
            'model' => $profile
        ]);

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

        $this->validateForm('Users\EditForm', $request, [
            'email' => 'required|email|unique:users,email,' . $profile->getKey()
        ]);

        $profile->update($request->all());

        chronicle()->record($profile, 'updated_profile');
        flash()->success(trans('users.edited'));

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

        $form = $this->form('Users\PasswordForm', [
            'method' => 'PUT',
            'url'    => route('reactor.profile.password.post'),
        ]);

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

        $this->validateForm('Users\PasswordForm', $request);

        $profile->setPassword($request->input('password'))->save();

        chronicle()->record($profile, 'changed_password');
        flash()->success(trans('users.changed_password'));

        return redirect()->route('reactor.profile.password');
    }
}
