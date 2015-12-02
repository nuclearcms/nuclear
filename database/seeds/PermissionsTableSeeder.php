<?php

use Illuminate\Database\Seeder;
use Reactor\ACL\Permission;
use Reactor\ACL\Role;

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

        // Create permissions and associate to admin
        $permissions = $this->getPermissionsList();
        $adminRole = Role::whereName('ADMIN')->first();

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
            $adminRole->givePermissionTo($permission);
        }

        // Associate editor permissions
        $editorPermissions = $this->getEditorPermissionsList();
        $editorRole = Role::whereName('EDITOR')->first();

        foreach($editorPermissions as $permission)
        {
            $editorRole->givePermissionTo($permission);
        }

    }

    /**
     * Returns the permissions list
     *
     * @return array
     */
    protected function getPermissionsList()
    {
        return [
            'ACCESS_ADVANCED',
            'ACCESS_CONTENTS',
            'ACCESS_CONTENTS_CREATE',
            'ACCESS_CONTENTS_DELETE',
            'ACCESS_CONTENTS_EDIT',
            'ACCESS_DOCUMENTS',
            'ACCESS_DOCUMENTS_DELETE',
            'ACCESS_DOCUMENTS_EDIT',
            'ACCESS_DOCUMENTS_EMBED',
            'ACCESS_DOCUMENTS_UPLOAD',
            'ACCESS_HISTORY',
            'ACCESS_NODES',
            'ACCESS_NODES_CREATE',
            'ACCESS_NODES_DELETE',
            'ACCESS_NODES_EDIT',
            'ACCESS_PERMISSIONS',
            'ACCESS_PERMISSIONS_CREATE',
            'ACCESS_PERMISSIONS_DELETE',
            'ACCESS_PERMISSIONS_EDIT',
            'ACCESS_REACTOR',
            'ACCESS_ROLES',
            'ACCESS_ROLES_CREATE',
            'ACCESS_ROLES_DELETE',
            'ACCESS_ROLES_EDIT',
            'ACCESS_SETTINGGROUPS',
            'ACCESS_SETTINGGROUPS_CREATE',
            'ACCESS_SETTINGGROUPS_DELETE',
            'ACCESS_SETTINGGROUPS_EDIT',
            'ACCESS_SETTINGS',
            'ACCESS_SETTINGS_CREATE',
            'ACCESS_SETTINGS_EDIT',
            'ACCESS_SETTINGS_DELETE',
            'ACCESS_SETTINGS_MODIFY',
            'ACCESS_USERS',
            'ACCESS_USERS_CREATE',
            'ACCESS_USERS_DELETE',
            'ACCESS_USERS_EDIT',
        ];
    }

    /**
     * Returns the editor permissions list
     *
     * @return array
     */
    protected function getEditorPermissionsList()
    {
        return [
            'ACCESS_CONTENTS',
            'ACCESS_CONTENTS_CREATE',
            'ACCESS_CONTENTS_DELETE',
            'ACCESS_CONTENTS_EDIT',
            'ACCESS_DOCUMENTS',
            'ACCESS_DOCUMENTS_DELETE',
            'ACCESS_DOCUMENTS_EDIT',
            'ACCESS_DOCUMENTS_EMBED',
            'ACCESS_DOCUMENTS_UPLOAD',
            'ACCESS_REACTOR',
        ];
    }

}
