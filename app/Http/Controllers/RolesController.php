<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Users\Role;
use Reactor\Http\Controllers\Traits\ModifiesPermissions;
use Reactor\Http\Controllers\Traits\UsesRoleForms;

class RolesController extends ReactorController {

    use UsesRoleForms, ModifiesPermissions;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = Role::class;
    protected $routeViewPrefix = 'roles';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::sortable()->paginate();

        return  $this->compileView('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('EDIT_ROLES');

        $form = $this->getCreateRoleForm();

        return $this->compileView('roles.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('EDIT_ROLES');

        $this->validateForm('Reactor\Html\Forms\Roles\CreateEditForm', $request);

        $role = Role::create($request->all());

        $this->notify('roles.created');

        return redirect()->route('reactor.roles.edit', $role->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $form = $this->getEditRoleForm($id, $role);

        return $this->compileView('roles.edit', compact('form', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('EDIT_ROLES');

        $role = Role::findOrFail($id);

        $this->validateUpdateRole($request, $role);

        $role->update($request->all());

        $this->notify('roles.edited');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('EDIT_ROLES');

        $role = Role::findOrFail($id);

        $role->delete();

        $this->notify('roles.destroyed');

        return redirect()->route('reactor.roles.index');
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $roles = Role::search($request->input('q'), 20, true)->get();

        return $this->compileView('roles.search', compact('roles'));
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        $this->authorize('EDIT_ROLES');

        $ids = json_decode($request->input('_bulkSelected', '[]'));

        Role::whereIn('id', $ids)->delete();

        $this->notify('roles.destroyed');

        return redirect()->route('reactor.roles.index');
    }

}