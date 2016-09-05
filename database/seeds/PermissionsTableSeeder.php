<?php

use Illuminate\Database\Seeder;
use Nuclear\Users\Permission;
use Nuclear\Users\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();

        // Create superadmin permissions
        $permissions = $this->getSuperadminPermissionsList();
        $role = Role::whereName('SUPERADMIN')->first();

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }

        // Create admin permissions
        $permissions = $this->getAdminPermissionsList();
        $role = Role::whereName('ADMINISTRATOR')->first();

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }

        // Associate editor permissions
        $permissions = $this->getEditorPermissionsList();
        $role = Role::whereName('EDITOR')->first();

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }

    }

    /**
     * Returns the permissions list the superadmin role
     *
     * @return array
     */
    protected function getSuperadminPermissionsList()
    {
        return ['SUPERADMIN'];
    }


    /**
     * Returns the permissions list the admin role
     *
     * @return array
     */
    protected function getAdminPermissionsList()
    {
        return [
            'ACCESS_MAINTENANCE',
            'ACCESS_NODETYPES',
            'EDIT_NODETYPES',
            'ACCESS_PERMISSIONS',
            'EDIT_PERMISSIONS',
            'ACCESS_ROLES',
            'EDIT_ROLES',
            'ACCESS_SETTINGGROUPS',
            'EDIT_SETTINGGROUPS',
            'ACCESS_SETTINGS',
            'EDIT_SETTINGS',
            'ACCESS_SETTINGSMODIFY',
            'EDIT_SETTINGSMODIFY',
            'ACCESS_UPDATE',
            'ACCESS_USERS',
            'EDIT_USERS'
        ];
    }

    /**
     * Returns the permissions list for the editor role
     *
     * @return array
     */
    protected function getEditorPermissionsList()
    {
        return [
            'ACCESS_REACTOR',
            'ACCESS_NODES',
            'EDIT_NODES',
            'ACCESS_DOCUMENTS',
            'EDIT_DOCUMENTS',
            'ACCESS_HISTORY',
            'ACCESS_MAILINGS',
            'EDIT_MAILINGS',
            'ACCESS_MAILINGLISTS',
            'EDIT_MAILINGLISTS',
            'ACCESS_SUBSCRIBERS',
            'EDIT_SUBSCRIBERS',
            'ACCESS_TAGS',
            'EDIT_TAGS'
        ];
    }

}
