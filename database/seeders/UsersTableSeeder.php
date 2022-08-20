<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Bapak RT 1',
                'email'          => 'bapak_rt_1@admin.com',
                'password'       => bcrypt('bapak_rt_1'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
