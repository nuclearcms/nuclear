<?php


namespace Reactor\Http\Controllers;


use Nuclear\Users\Permission;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesPermissionForms;

class PermissionsController extends ReactorController {

    use BasicResource, UsesPermissionForms;

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = Permission::class;
    protected $resourceMultiple = 'permissions';
    protected $resourceSingular = 'permission';
    protected $permissionKey = 'PERMISSIONS';

}