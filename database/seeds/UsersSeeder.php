<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'project@baddi.info',
            'role' => 'SUPER_ADMIN',
            'password' => Hash::make('bad@2020')
        ]);
    }
}
