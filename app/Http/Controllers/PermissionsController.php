<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Users\Permission;
use Reactor\Http\Controllers\Traits\UsesPermissionForms;

class PermissionsController extends ReactorController {

    use UsesPermissionForms;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::sortable()->paginate();

        return $this->compileView('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('EDIT_PERMISSIONS');

        $form = $this->getCreatePermissionForm();

        return $this->compileView('permissions.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('EDIT_PERMISSIONS');

        $this->validateForm('Reactor\Html\Forms\Permissions\CreateEditForm', $request);

        $permission = Permission::create($request->all());

        $this->notify('permissions.created');

        return redirect()->route('reactor.permissions.edit', $permission->getKey());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('EDIT_PERMISSIONS');

        $permission = Permission::findOrFail($id);

        $permission->delete();

        $this->notify('permissions.destroyed');

        return redirect()->route('reactor.permissions.index');
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $permissions = Permission::search($request->input('q'), 20, true)->get();

        return $this->compileView('permissions.search', compact('permissions'));
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        $this->authorize('EDIT_PERMISSIONS');

        $ids = json_decode($request->input('_bulkSelected', '[]'));

        Permission::whereIn('id', $ids)->delete();

        $this->notify('permissions.destroyed');

        return redirect()->route('reactor.permissions.index');
    }

}