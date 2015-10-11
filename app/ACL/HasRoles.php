<?php

namespace Reactor\ACL;


trait HasRoles {

    /**
     * Roles relation
     *
     * @return Relation
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the user has role(s)
     *
     * @param string|array $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role))
        {
            return $this->roles->contains('name', $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    /**
     * Assign a role to the user
     *
     * @param string $role
     * @return Role
     */
    public function assignRole($role)
    {
        return $this->roles()->attach(
            Role::whereName($role)->firstOrFail()
        );
    }

    /**
     * Assign a role to the user by id
     *
     * @param int $id
     * @return Role
     */
    public function assignRoleById($id)
    {
        return $this->roles()->attach(
            Role::findOrFail($id)
        );
    }

    /**
     * Retract a role from the user
     *
     * @param string $role
     * @return Role
     */
    public function retractRole($role)
    {
        return $this->roles()->detach(
            Role::whereName($role)->firstOrFail()
        );
    }

}