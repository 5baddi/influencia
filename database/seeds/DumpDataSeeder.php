<?php

use App\Brand;
use App\Campaign;
use App\Influencer;
use App\Services\InstagramScraper;
use App\Tracker;
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
        $campaign = Campaign::create([
            'name'      =>  'Camp 01',
            'user_id'   =>  $user->id,
            'brand_id'  =>  $brand->id,
            'status'    =>  true
        ]);
        Tracker::create([
            'name'  =>  'Test 1',
            'type'  =>  'post',
            'platform'  =>  'instagram',
            'user_id'   =>  $user->id,
            'campaign_id'   =>  $campaign->id,
            'url'           =>  'https://www.instagram.com/p/CBnLKgAi79w/'
        ]);
        Tracker::create([
            'name'  =>  'Test 2',
            'type'  =>  'post',
            'platform'  =>  'instagram',
            'user_id'   =>  $user->id,
            'campaign_id'   =>  $campaign->id,
            'url'           =>  'https://www.instagram.com/p/B_iDEz7iBr9/'
        ]);

        // Influencers
        $demoAccount = $instagramScraper->byUsername("autoservicesrouen76");
        // $demoAccount2 = $instagramScraper->byUsername("exotics.worldwide");
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
        // Influencer::create([
        //     'account_id'    =>  $demoAccount2['id'],
        //     'username'      =>  $demoAccount2['username'],
        //     'name'          =>  $demoAccount2['fullName'],
        //     'pic_url'       =>  $demoAccount2['profilePicUrlHd'],
        //     'biography'     =>  $demoAccount2['biography'],
        //     'website'       =>  $demoAccount2['externalUrl'],
        //     'followers'     =>  $demoAccount2['followedByCount'],
        //     'follows'       =>  $demoAccount2['followsCount'],
        //     'posts'         =>  $demoAccount2['mediaCount'],
        //     'is_business'   =>  $demoAccount2['isBusinessAccount'],
        //     'is_private'    =>  $demoAccount2['isPrivate'],
        //     'is_verified'   =>  $demoAccount2['isVerified'],
        // ]);
    }
}