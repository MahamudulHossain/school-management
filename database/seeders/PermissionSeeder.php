<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $user_type = [
            ['id' => '1','title' => 'Admin', 'status'=>'Active']
        ];
        \App\Models\UserType::insert($user_type);

        $user = [
            [
                'id' => '1',
                'name' => 'SuperAdmin',
                'email' => 'superadmin@hossainn.com',
                'password' => bcrypt('123456'),
                'user_type_id' => 1,
                'web_access' => '1',
            ],
            [
                'id' => '2',
                'name' => 'SystemAdmin',
                'email' => 'systemadmin@hossainn.com',
                'password' => bcrypt('123456'),
                'user_type_id' => 1,
                'web_access' => '1',
            ]

        ];
        foreach ($user as $key => $value) {
            \App\Models\User::create($value);
        }
        $profile = [
            ['user_id' => '1','gender' => 'Male','address' => 'Dhaka'],
            ['user_id' => '2','gender' => 'Male','address' => 'Dhaka']
        ];
        \DB::table('profiles')->insert($profile);

        $image_profile = [
            ['user_id' => '1','image' => 'default_image.png'],
            ['user_id' => '2','image' => 'default_image.png']
        ];
        \DB::table('image_profiles')->insert($image_profile);

        $permissions = [
            ['title' => 'UserAccess'],
            ['title' => 'UserDelete'],
            ['title' => 'RoleAccess'],
            ['title' => 'UserTypeAccess'],
            ['title' => 'SettingsAccess'],
        ];
        \App\Models\Permission::insert($permissions);

        $roles = [
            ['id'=>1,'title' => 'Admin Role'],
        ];
        \App\Models\Role::insert($roles);

        $role_user_type = [
            ['user_type_id' => 1, 'role_id' => 1]
        ];
        \DB::table('role_user_types')->insert($role_user_type);

        //        Permission Roll Table
        $admin_permissions = \App\Models\Permission::all();
        \App\Models\Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        \App\Models\User::findOrFail(1)->roles()->sync(1);
    }
}

