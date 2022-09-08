<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\ApplicationSetting;
use Illuminate\Database\Seeder;

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

        // Super admin
        $user = User::create([
            'name'              =>  'Super Admin',
            'email'             =>  'project@baddi.info',
            'password'          =>  'baddidev',
            'is_superadmin'     =>  true
        ]);
    }
}
