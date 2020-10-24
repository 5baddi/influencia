<?php

use App\ApplicationSetting;
use App\Role;
use App\User;
use App\Brand;
use App\Tracker;
use App\Campaign;
use App\Influencer;
use App\Permission;
use Illuminate\Database\Seeder;
use App\Services\InstagramScraper;
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
        // Create default application setting
        ApplicationSetting::create([
            'key'   =>  'usd2eur',
            'name'  =>  'USD/EUR',
            'value' =>  0.84
        ]);
        // Create default roles
        $ownerRole = Role::create(['name' => 'owner']);

        // Create permissions
        $permissions = [
            'list_brand',
            'show_brand',
            'list_campaign',
            'show_campaign',
            'analytics_campaign',
            'create_campaign',
            'rename_campaign',
            'disable_campaign',
            'delete_campaign',
            'show_tracker',
            'list_tracker',
            'create_tracker',
            'edit_tracker',
            'delete_tracker',
            'list_influencer',
            'show_influencer',
            'change-password_user',
            'edit-info_user',
        ];

        foreach($permissions as $item){
            $permission = Permission::create(['name' => $item]);
            $ownerRole->permissions()->attach($permission->id);
        }
        
        // Insert data for testing
        $brand = Brand::create([
            'name'  =>  'Promo',
            'logo'  =>  '/storage/uploads/promo.png'
        ]);
        $user = User::create([
            'name'              =>  'Webmaster',
            'email'             =>  'project@baddi.info',
            'password'          =>  Hash::make('web2020'),
            'is_superadmin'     =>  true,
            'selected_brand_id' =>  $brand->id
        ]);
        $owner = User::create([
            'name'              =>  'Owner',
            'email'             =>  'owner@baddi.info',
            'password'          =>  Hash::make('web2020'),
            'selected_brand_id' =>  $brand->id,
            'role_id'           =>  $ownerRole->id
        ]);
        $brand->users()->attach([$user->id, $owner->id]);
        $campaign = Campaign::create([
            'name'      =>  'Camp 01',
            'user_id'   =>  $user->id,
            'brand_id'  =>  $brand->id,
            'status'    =>  true
        ]);
        // Tracker::create([
        //     'name'  =>  'Tracker 1',
        //     'type'  =>  'post',
        //     'platform'  =>  'instagram',
        //     'user_id'   =>  $user->id,
        //     'campaign_id'   =>  $campaign->id,
        //     'url'           =>  'https://www.instagram.com/p/CB5zGnmomWp/'
        // ]);

        // Influencers
        // $demoAccount = $instagramScraper->byUsername("autoservicesrouen76");
        // $demoAccount2 = $instagramScraper->byUsername("exotics.worldwide");
        // Influencer::create([
        //     'account_id'    =>  $demoAccount['id'],
        //     'username'      =>  $demoAccount['username'],
        //     'name'          =>  $demoAccount['fullName'],
        //     'pic_url'       =>  $demoAccount['profilePicUrlHd'],
        //     'biography'     =>  $demoAccount['biography'],
        //     'website'       =>  $demoAccount['externalUrl'],
        //     'followers'     =>  $demoAccount['followedByCount'],
        //     'follows'       =>  $demoAccount['followsCount'],
        //     'posts'         =>  $demoAccount['mediaCount'],
        //     'is_business'   =>  $demoAccount['isBusinessAccount'],
        //     'is_private'    =>  $demoAccount['isPrivate'],
        //     'is_verified'   =>  $demoAccount['isVerified'],
        // ]);
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
