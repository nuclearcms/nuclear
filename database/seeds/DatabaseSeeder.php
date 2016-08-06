<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);

        // We truncate the activities table so that
        // there won't be any irrelevant activity feed
        DB::table('activities')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}
