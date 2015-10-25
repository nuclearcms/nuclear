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

        $form = $this->getCreateUserForm();

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

        $this->notify('users.created');

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

        $form = $this->getEditUserForm($id, $profile);

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

        $this->validateEditUserForm($request, $profile);

        $profile->update($request->all());

        $this->notify('users.edited', 'updated_user_information', $profile);

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

        $this->notify('users.deleted');

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

        $form = $this->getPasswordForm($id);

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

        $this->notify('users.changed_password', 'changed_user_password', $profile);

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

        $this->notify('users.added_role', 'assigned_role_to_user', $user);

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

        $this->notify('users.unlinked_role', 'retracted_role_from_user', $user);

        return redirect()->back();
    }

    /**
     * Shows the history for the user
     *
     * @param int $id
     * @return Response
     */
    public function history($id)
    {
        $profile = User::findOrFail($id);

        $activities = chronicle()->getUserActivity($id, 20);

        return view('users.history')
            ->with(compact('profile', 'activities'));
    }

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateUserForm()
    {
        $form = $this->form('Users\CreateForm', [
            'url' => route('reactor.users.store')
        ]);

        return $form;
    }

    /**
     * @param $id
     * @param $profile
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditUserForm($id, $profile)
    {
        $form = $this->form('Users\EditForm', [
            'url'   => route('reactor.users.update', $id),
            'model' => $profile
        ]);

        return $form;
    }

    /**
     * @param Request $request
     * @param $profile
     */
    protected function validateEditUserForm(Request $request, $profile)
    {
        $this->validateForm('Users\EditForm', $request, [
            'email' => 'required|email|unique:users,email,' . $profile->getKey()
        ]);
    }

    /**
     * @param $id
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getPasswordForm($id)
    {
        $form = $this->form('Users\PasswordForm', [
            'url' => route('reactor.users.password.post', $id),
        ]);

        return $form;
    }

}