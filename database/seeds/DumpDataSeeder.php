<?php

use App\Brand;
use App\Campaign;
use App\Influencer;
use App\Services\InstagramScraper;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DumpDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(InstagramScraper $instagramScraper)
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

        // Influencers
        // Demo account: exotics.worldwide
        $demoAccount = $instagramScraper->byUsername("autoservicesrouen76");
        Influencer::create([
            'account_id'    =>  $demoAccount['id'],
            'username'      =>  $demoAccount['username'],
            'name'          =>  $demoAccount['fullName'],
            'pic_url'       =>  $demoAccount['profilePicUrlHd'],
            'biography'     =>  $demoAccount['biography'],
            'website'       =>  $demoAccount['externalUrl'],
            'followers'     =>  $demoAccount['followedByCount'],
            'follows'       =>  $demoAccount['followsCount'],
            'posts'         =>  $demoAccount['mediaCount'],
            'is_business'   =>  $demoAccount['isBusinessAccount'],
            'is_private'    =>  $demoAccount['isPrivate'],
            'is_verified'   =>  $demoAccount['isVerified'],
        ]);
    }
}
