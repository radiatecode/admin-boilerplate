<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Tenant;
use App\Services\AvatarService;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Tools\Constant\Constant;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::query()->where('role_name', 'Super Admin')->first();

        $user = new User();

        $user->uuid = Str::uuid();
        $user->name = 'Ashadozzaman';
        $user->email = 'shovoua@gmail.com';
        $user->phone = '01762662171';
        $user->gender = "Male";
        $user->email_verified_at = now();
        $user->password = Hash::make('shovoua@gmail.com');
        $user->is_active = 1;
        $user->is_supper = 1;
        $user->role_id = $role->id;
        // $user->avatar = AvatarService::make()->avatarFromName('Ashadozzaman');
        $user->saveQuietly();

        $user->roles()->attach($role->id, [
            'created_by' => $user->id
        ]);
        // $user->save();
    }
}
