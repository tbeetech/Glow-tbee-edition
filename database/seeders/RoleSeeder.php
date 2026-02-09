<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $staffRole = Role::firstOrCreate([
            'name' => 'staff',
            'guard_name' => 'web',
        ]);

        User::query()->get()->each(function (User $user) use ($adminRole, $staffRole) {
            if ($user->roles->isNotEmpty()) {
                return;
            }

            if ($user->role === 'admin') {
                $user->assignRole($adminRole);
                return;
            }

            if (in_array($user->role, ['staff', 'corp_member', 'intern'], true)) {
                $user->assignRole($staffRole);
            }
        });
    }
}
