<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'User',
            ],
            [
                'id' => 3,
                'title' => 'Bapak RT'
            ],
            [
                'id' => 4,
                'title' => 'Masyarakat',
            ],
        ];

        Role::insert($roles);
    }
}
