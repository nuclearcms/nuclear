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

        $form = $this->getAddPermissionForm($id, $model, $modelPrefix);

        return $this->compileView($modelPrefix . '.permissions', compact('model', 'form', 'permissions'), trans('permissions.title'));
    }

    /**
     * Returns necessary resource names
     *
     * @return array
     */
    protected function getResourceNames()
    {
        return [
            'modelPath'   => $this->modelPath,
            'modelPrefix' => $this->routeViewPrefix
        ];
    }

    /**
     * Creates a form for adding permissions
     *
     * @param int $id
     * @param Model $model
     * @param string $modelPrefix
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getAddPermissionForm($id, Model $model, $modelPrefix)
    {
        $form = $this->form('Reactor\Html\Forms\Permissions\AddPermissionForm', [
            'url' => route('reactor.' . $modelPrefix . '.permission.add', $id)
        ]);

        $choices = Permission::all()
            ->diff($model->permissions)
            ->pluck('name', 'id')
            ->toArray();

        $form->modify('permission', 'select', [
            'choices' => $choices
        ]);

        return $form;
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
        $this->validateForm('Reactor\Http\Forms\Permissions\AddPermissionForm', $request);

        extract($this->getResourceNames());

        $model = $modelPath::findOrFail($id);

        $model->givePermissionById($request->input('permission'));

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

        $model = $modelPath::findOrFail($id);

        $model->revokePermission($request->input('permission'));

        $this->notify('permissions.revoked', 'revoked_permission', $model);

        return redirect()->back();
    }

}