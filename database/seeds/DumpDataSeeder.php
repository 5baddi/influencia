<?php

use App\Role;
use App\User;
use App\Brand;
use App\Permission;
use App\ApplicationSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DumpDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default application setting
        ApplicationSetting::create([
            'key'   =>  'usd2eur',
            'name'  =>  'USD/EUR',
            'value' =>  0.84
        ]);
        ApplicationSetting::create([
            'key'   =>  'fbcostperimpressions',
            'name'  =>  'Facebook cost per impressions',
            'value' =>  7.19
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
            'analytics_tracker',
            'change-status_tracker',
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
            'logo'  =>  '/uploads/promo.png'
        ]);

        $user = User::create([
            'name'              =>  'Webmaster',
            'email'             =>  'project@baddi.info',
            'password'          =>  Hash::make('inf2021'),
            'is_superadmin'     =>  true,
            'selected_brand_id' =>  $brand->id
        ]);

        $brand->users()->attach([$user->id]);
    }
}
