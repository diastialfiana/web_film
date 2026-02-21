<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Aldmic User',
            'username' => 'aldmic',
            'password' => bcrypt('123abc123'),
        ]);
    }
}
