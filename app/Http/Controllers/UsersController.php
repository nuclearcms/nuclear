<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\User;

class UsersController extends ReactorController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::sortable()->paginate();

        return view('users.index')
            ->with(compact('users'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $users = User::search($request->input('q'))->get();

        return view('users.search')
            ->with(compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $form = $this->form('Users\CreateForm', [
            'method' => 'POST',
            'url'    => route('reactor.users.store')
        ]);

        return view('users.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validateForm('Users\CreateForm', $request);

        $profile = User::create($request->all());

        flash()->success(trans('users.created'));

        return redirect()->route('reactor.users.edit', $profile->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $profile = User::findOrFail($id);

        $form = $this->form('Users\EditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.users.update', $id),
            'model' => $profile
        ]);

        return view('users.edit', compact('form', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $profile = User::findOrFail($id);

        $this->validateForm('Users\EditForm', $request, [
            'email' => 'required|email|unique:users,email,' . $profile->getKey()
        ]);

        $profile->update($request->all());

        flash()->success(trans('users.edited'));

        return redirect()->route('reactor.users.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        flash()->success(trans('users.deleted'));

        return redirect()->route('reactor.users.index');
    }

    /**
     * Show the form for updating password.
     *
     * @param int $id
     * @return Response
     */
    public function password($id)
    {
        $profile = User::findOrFail($id);

        $form = $this->form('Users\PasswordForm', [
            'method' => 'PUT',
            'url'    => route('reactor.users.password.post', $id),
        ]);

        return view('users.password', compact('form', 'profile'));
    }

    /**
     * Update users password
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updatePassword(Request $request, $id)
    {
        $profile = User::findOrFail($id);

        $this->validateForm('Users\PasswordForm', $request);

        $profile->setPassword($request->input('password'))->save();

        flash()->success(trans('users.changed_password'));

        return redirect()->route('reactor.users.password', $id);
    }

}
