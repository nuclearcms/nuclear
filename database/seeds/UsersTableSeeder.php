<?php

use Illuminate\Database\Seeder;
use Reactor\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $email = 'john@doe.com';
        $password = bcrypt('secret');

        DB::table('users')->insert([
            'email' => $email,
            'password' => $password,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $user = User::whereEmail($email)->first();

        // We have to login the user for further convenience
        auth()->login($user);
    }
}