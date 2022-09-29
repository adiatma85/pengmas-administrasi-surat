<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        // User Permission
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);

        // Bapak RT Permission
        $bapakRtPermission = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(3)->permissions()->sync($bapakRtPermission);

        // Masyarakat Permission
        $masyarakatPermissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 8) == 'profile_' || substr($permission->title, 0, 10) == 'pengajuan_';
        });
        Role::findOrFail(4)->permissions()->sync($masyarakatPermissions);
    }
}
