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
    }
}