<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789'),
            'role_as'=>'admin',
        ]);

        User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('123456789'),
            'role_as'=>'user',
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('123456789'),
            'role_as'=>'user',
        ]);

        User::create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => bcrypt('123456789'),
            'role_as'=>'user',
        ]);

        User::create([
            'name' => 'user4',
            'email' => 'user4@gmail.com',
            'password' => bcrypt('123456789'),
            'role_as'=>'user',
        ]);

        User::create([
            'name' => 'user5',
            'email' => 'user5@gmail.com',
            'password' => bcrypt('123456789'),
            'role_as'=>'user',
        ]);
    }
}
