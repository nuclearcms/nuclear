<?php

namespace Reactor\Http\Controllers\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Reactor\ACL\Permission;

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

        $model = $modelPath::with('permissions')->findOrFail($id);

        $form = $this->getAddPermissionForm($id, $model, $modelPrefix);

        return view($modelPrefix . '.permissions')
            ->with(compact('model', 'form'));
    }

    /**
     * Returns necessary resource names
     *
     * @return array
     */
    protected function getResourceNames()
    {
        return [
            'modelPath' => $this->modelPath,
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
        $form = $this->form('Permissions\AddPermissionForm', [
            'method' => 'PUT',
            'url'    => route('reactor.' . $modelPrefix . '.permission.add', $id)
        ]);

        $choices = Permission::all()
            ->diff($model->permissions)
            ->lists('name', 'id')
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
        $this->validateForm('Permissions\AddPermissionForm', $request);

        extract($this->getResourceNames());

        $model = $modelPath::findOrFail($id);

        $model->givePermissionById($request->input('permission'));

        chronicle()->record($model, 'added_permission');
        flash()->success(trans('users.added_permission'));

        return redirect()->back();
    }

    /**
     * Remove a permission from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function removePermission(Request $request, $id)
    {
        extract($this->getResourceNames());

        $model = $modelPath::findOrFail($id);

        $model->revokePermission($request->input('permission'));

        chronicle()->record($model, 'revoked_permission');
        flash()->success(trans('users.unlinked_permission'));

        return redirect()->back();
    }

}