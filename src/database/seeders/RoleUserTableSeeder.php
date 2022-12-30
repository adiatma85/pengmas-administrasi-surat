<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->roles()->sync(1);

        // Role Bapak RT 1
        User::findOrFail(2)->roles()->sync(3);

        // Role Masyarakat 1
        User::findOrFail(3)->roles()->sync(4);
    }
}
