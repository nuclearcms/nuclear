<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\ACL\Role;
use Reactor\Http\Controllers\Traits\ModifiesPermissions;
use Reactor\User;

class UsersController extends ReactorController {

    use ModifiesPermissions;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = User::class;
    protected $routeViewPrefix = 'users';

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
        $this->authorize('ACCESS_USERS_CREATE');

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
        $this->authorize('ACCESS_USERS_CREATE');

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
        $this->authorize('ACCESS_USERS_EDIT');

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
        $this->authorize('ACCESS_USERS_EDIT');

        $profile = User::findOrFail($id);

        $this->validateForm('Users\EditForm', $request, [
            'email' => 'required|email|unique:users,email,' . $profile->getKey()
        ]);

        $profile->update($request->all());

        chronicle()->record($profile, 'updated_user_information');
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
        $this->authorize('ACCESS_USERS_DELETE');

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

        chronicle()->record($profile, 'updated_user_password');
        flash()->success(trans('users.changed_password'));

        return redirect()->route('reactor.users.password', $id);
    }

    /**
     * List the specified resource roles.
     *
     * @param int $id
     * @return Response
     */
    public function roles($id)
    {
        $profile = User::with('roles')->findOrFail($id);

        $form = $this->getAddRoleForm($id, $profile);

        return view('users.roles')
            ->with(compact('profile', 'form'));
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
        $form = $this->form('Roles\AddRoleForm', [
            'method' => 'PUT',
            'url'    => route('reactor.users.role.add', $id)
        ]);

        $choices = Role::all()
            ->diff($user->roles)
            ->lists('label', 'id')
            ->toArray();

        $form->modify('role', 'select', [
            'choices' => $choices
        ]);

        return $form;
    }

    /**
     * Add a role to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function addRole(Request $request, $id)
    {
        $this->validateForm('Roles\AddRoleForm', $request);

        $user = User::findOrFail($id);

        $user->assignRoleById($request->input('role'));

        chronicle()->record($user, 'added_role_to_user');
        flash()->success(trans('users.added_role'));

        return redirect()->back();
    }

    /**
     * Remove a permission from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function removeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->retractRole($request->input('role'));

        chronicle()->record($user, 'removed_role_from_user');
        flash()->success(trans('users.unlinked_role'));

        return redirect()->back();
    }

}
