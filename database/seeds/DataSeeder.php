<?php

use App\Brand;
use App\Campaign;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert data for testing
        $brand = Brand::create([
            'name'  =>  'Promo',
            'logo'  =>  '/storage/uploads/promo.png'
        ]);
        $user = User::create([
            'name'              =>  'Webmaster',
            'email'             =>  'project@baddi.info',
            'password'          =>  Hash::make('web2020'),
            'role'              =>  'SUPER_ADMIN',
            'selected_brand_id' =>  $brand->id
        ]);
        $brand->users()->attach($user);
        Campaign::create([
            'name'      =>  'Camp 01',
            'user_id'   =>  $user->id,
            'brand_id'  =>  $brand->id,
            'status'    =>  true
        ]);
    }
}
