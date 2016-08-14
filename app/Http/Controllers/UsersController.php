<?php


namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\ModifiesPermissions;
use Reactor\Http\Controllers\Traits\UsesUserForms;
use Nuclear\Users\User;

class UsersController extends ReactorController {

    use ModifiesPermissions, UsesUserForms;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = User::class;
    protected $routeViewPrefix = 'users';
    protected $permissionKey = 'USERS';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::sortable()->paginate();

        return $this->compileView('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('EDIT_USERS');

        $form = $this->getCreateUserForm();

        return $this->compileView('users.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('EDIT_USERS');

        $this->validateForm('Reactor\Html\Forms\Users\CreateForm', $request);

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
        $profile = User::findOrFail($id);

        $form = $this->getEditUserForm($id, $profile);

        return $this->compileView('users.edit', compact('form', 'profile'));
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
        $this->authorize('EDIT_USERS');

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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('EDIT_USERS');

        $user = User::findOrFail($id);

        $user->delete();

        $this->notify('users.destroyed');

        return redirect()->route('reactor.users.index');
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $users = User::search($request->input('q'), 20, true)->get();

        return $this->compileView('users.search', compact('users'));
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        $this->authorize('EDIT_USERS');

        $ids = json_decode($request->input('_bulkSelected', '[]'));

        User::whereIn('id', $ids)->delete();

        $this->notify('users.destroyed');

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
        $this->authorize('EDIT_USERS');

        $profile = User::findOrFail($id);

        $form = $this->getPasswordForm($id);

        return $this->compileView('users.password', compact('form', 'profile'), trans('users.change_password'));
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
        $this->authorize('EDIT_USERS');

        $profile = User::findOrFail($id);

        $this->validateForm('Reactor\Html\Forms\Users\PasswordForm', $request);

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

        list($form, $count) = $this->getAddRoleForm($id, $profile);

        return $this->compileView('users.roles', compact('profile', 'form', 'count'), trans('roles.title'));
    }

    /**
     * Associate a role to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function associateRole(Request $request, $id)
    {
        $this->authorize('EDIT_USERS');

        $this->validateForm('Reactor\Html\Forms\Roles\AddRoleForm', $request);

        $user = User::findOrFail($id);

        $user->assignRoleById($request->input('role'));

        $this->notify('roles.associated', 'assigned_role_to_user', $user);

        return redirect()->back();
    }

    /**
     * Dissociate a role from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function dissociateRole(Request $request, $id)
    {
        $this->authorize('EDIT_USERS');

        $user = User::findOrFail($id);

        $user->retractRole($request->input('role'));

        $this->notify('roles.dissociated', 'retracted_role_from_user', $user);

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

        return $this->compileView('users.history', compact('profile', 'activities'), trans('general.history'));
    }

}