<?php


namespace Reactor\Http\Controllers;


use Nuclear\Users\Permission;

class PermissionsController extends ReactorController {

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

}