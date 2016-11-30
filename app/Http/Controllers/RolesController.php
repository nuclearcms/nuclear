<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Users\Role;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\ModifiesPermissions;
use Reactor\Http\Controllers\Traits\UsesRoleForms;

class RolesController extends ReactorController {

    use BasicResource, UsesRoleForms, ModifiesPermissions;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = Role::class;
    protected $resourceMultiple = 'roles';
    protected $resourceSingular = 'role';
    protected $permissionKey = 'ROLES';

    /**
     * List the specified resource users.
     *
     * @param int $id
     * @return Response
     */
    public function users($id)
    {
        $role = Role::with('users')->findOrFail($id);

        list($form, $count) = $this->getAddUserForm($id, $role);

        return $this->compileView('roles.users', compact('role', 'form', 'count'), trans('users.title'));
    }

    /**
     * Add an user to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function associateUser(Request $request, $id)
    {
        $this->authorize('EDIT_USERS');

        $this->validateForm('Reactor\Html\Forms\Users\AddUserForm', $request);

        $role = Role::findOrFail($id);

        $role->associateUser($request->input('user'));

        app('reactor.viewcache')->flushReactor();

        $this->notify('users.associated', 'associated_user_to_role', $role);

        return redirect()->back();
    }

    /**
     * Remove an user from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function dissociateUser(Request $request, $id)
    {
        $this->authorize('EDIT_USERS');

        $role = Role::findOrFail($id);

        $role->dissociateUser($request->input('user'));

        app('reactor.viewcache')->flushReactor();

        $this->notify('users.dissociated', 'dissociated_user_from_role', $role);

        return redirect()->route('reactor.roles.users', $id);
    }

}