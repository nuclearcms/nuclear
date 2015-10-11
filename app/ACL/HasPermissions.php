<?php

namespace Reactor\ACL;


trait HasPermissions {

    /**
     * Permissions relation
     *
     * @return Relation
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if the user has permission(s)
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->permissions->contains('name', $permission);
    }

    /**
     * Give a permission to the user
     *
     * @param string $permission
     * @return Permission
     */
    public function givePermissionTo($permission)
    {
        return $this->permissions()->attach(
            Permission::whereName($permission)->firstOrFail()
        );
    }

    /**
     * Give a permission to the user by id
     *
     * @param int $id
     * @return Permission
     */
    public function givePermissionById($id)
    {
        return $this->permissions()->attach(
            Permission::findOrFail($id)
        );
    }

    /**
     * Revoke a permission from the user
     *
     * @param string $permission
     * @return Permission
     */
    public function revokePermission($permission)
    {
        return $this->permissions()->detach(
            Permission::whereName($permission)->firstOrFail()
        );
    }

}