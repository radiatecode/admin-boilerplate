<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use RadiateCode\PermissionNameGenerator\Permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permissions::make()->getOnlyPermissionsNames();

        $role = new Role();

        $role->uuid = Str::uuid();
        $role->role_name = 'Super Admin';
        $role->role_slug = Str::slug('Super Admin');
        $role->role_permissions = json_encode($permissions);
        $role->system = 1;

        $role->saveQuietly(); // do not dispatch any model events
        $role->save();
    }
}
