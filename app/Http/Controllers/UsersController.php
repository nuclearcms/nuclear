<?php


namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\ModifiesPermissions;
use Reactor\Http\Controllers\Traits\UsesUserForms;
use Nuclear\Users\User;

class UsersController extends ReactorController {

    use BasicResource, UsesUserForms, ModifiesPermissions;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = User::class;
    protected $resourceMultiple = 'users';
    protected $resourceSingular = 'profile';
    protected $permissionKey = 'USERS';

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