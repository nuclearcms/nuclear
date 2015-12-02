<?php

use Illuminate\Database\Seeder;
use Reactor\ACL\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        Role::create(['name' => 'ADMIN', 'label' => 'Administrator']);
        Role::create(['name' => 'EDITOR', 'label' => 'Editor']);

        // At this point our user is logged in so we can
        // assign the role.
        $user = auth()->user();
        $user->assignRole('ADMIN');
    }
}