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
            'name' => 'Amine sahmoudi',
            'email' => 'amine.sahmoudi@tcagency.ma',
            'role' => 'SUPER_ADMIN',
            'password' => Hash::make('amine.sahmoudi@tcagency.ma')
        ]);
    }
}
