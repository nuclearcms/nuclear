<?php

use Illuminate\Database\Seeder;
use Nuclear\Users\Role;

class RolesTableSeeder extends Seeder
{
    /** @var array */
    protected $roles = [
        'en' => [
            ['name' => 'SUPERADMIN', 'label' => 'Super Admin'],
            ['name' => 'ADMINISTRATOR', 'label' => 'Administrator'],
            ['name' => 'EDITOR', 'label' => 'Editor']
        ],
        'tr' => [
            ['name' => 'SUPERADMIN', 'label' => 'Üstün Yönetici'],
            ['name' => 'ADMINISTRATOR', 'label' => 'Admin'],
            ['name' => 'EDITOR', 'label' => 'Editör']
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        $locale = env('REACTOR_LOCALE', 'en');

        $roles = $this->roles[$locale];

        foreach($roles as $role)
        {
            Role::create($role);
        }
    }
}