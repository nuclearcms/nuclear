<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Nuclear\Users\Permission;

trait ModifiesPermissions {

    /**
     * List the specified resource permissions.
     *
     * @param int $id
     * @return Response
     */
    public function permissions($id)
    {
        extract($this->getResourceNames());

        $model = $modelPath::findOrFail($id);
        $permissions = $model->permissions()->orderBy('name')->get();

        list($form, $count) = $this->getAddPermissionForm($id, $model, $resourceMultiple);

        $parameters = compact('form', 'count', 'permissions');
        $parameters[$resourceSingular] = $model;

        return $this->compileView($resourceMultiple . '.permissions', $parameters, trans('permissions.title'));
    }

    /**
     * Creates a form for adding permissions
     *
     * @param int $id
     * @param Model $model
     * @param string $resourceMultiple
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getAddPermissionForm($id, Model $model, $resourceMultiple)
    {
        $form = $this->form('Reactor\Html\Forms\Permissions\AddPermissionForm', [
            'url' => route('reactor.' . $resourceMultiple . '.permissions.add', $id)
        ]);

        $choices = Permission::all()
            ->diff($model->permissions)
            ->pluck('name', 'id')
            ->toArray();

        $form->modify('permission', 'select', [
            'choices' => $choices
        ]);

        return [$form, count($choices)];
    }

    /**
     * Add a permission to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function addPermission(Request $request, $id)
    {
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $this->validateForm('Reactor\Html\Forms\Permissions\AddPermissionForm', $request);

        $model = $modelPath::findOrFail($id);

        $model->givePermissionById($request->input('permission'));

        app('reactor.viewcache')->flushReactor();

        $this->notify('permissions.added', 'added_permission', $model);

        return redirect()->back();
    }

    /**
     * Remove a permission from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function revokePermission(Request $request, $id)
    {
        extract($this->getResourceNames());

        $this->authorize('EDIT_' . $permissionKey);

        $model = $modelPath::findOrFail($id);

        $model->revokePermission($request->input('permission'));

        app('reactor.viewcache')->flushReactor();

        $this->notify('permissions.revoked', 'revoked_permission', $model);

        return redirect()->back();
    }

}