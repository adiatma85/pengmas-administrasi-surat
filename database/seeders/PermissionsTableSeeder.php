<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'data_kependudukan_access',
            ],
            [
                'id'    => 18,
                'title' => 'kependudukan_create',
            ],
            [
                'id'    => 19,
                'title' => 'kependudukan_edit',
            ],
            [
                'id'    => 20,
                'title' => 'kependudukan_show',
            ],
            [
                'id'    => 21,
                'title' => 'kependudukan_delete',
            ],
            [
                'id'    => 22,
                'title' => 'kependudukan_access',
            ],
            [
                'id'    => 23,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 24,
                'title' => 'surat_menyurat_access',
            ],
            [
                'id'    => 25,
                'title' => 'entry_mail_create',
            ],
            [
                'id'    => 26,
                'title' => 'entry_mail_edit',
            ],
            [
                'id'    => 27,
                'title' => 'entry_mail_show',
            ],
            [
                'id'    => 28,
                'title' => 'entry_mail_delete',
            ],
            [
                'id'    => 29,
                'title' => 'entry_mail_access',
            ],
            [
                'id'    => 30,
                'title' => 'pengajuan_surat_access',
            ],
            [
                'id'    => 31,
                'title' => 'pengajuan_surat_create',
            ],
            [
                'id'    => 32,
                'title' => 'pengajuan_surat_edit',
            ],
            [
                'id'    => 33,
                'title' => 'pengajuan_surat_show',
            ],
            [
                'id'    => 34,
                'title' => 'pengajuan_surat_delete',
            ],
            [
                'id'    => 35,
                'title' => 'pengumuman_dan_beritum_access',
            ],
            [
                'id'    => 36,
                'title' => 'beritum_create',
            ],
            [
                'id'    => 37,
                'title' => 'beritum_edit',
            ],
            [
                'id'    => 38,
                'title' => 'beritum_show',
            ],
            [
                'id'    => 39,
                'title' => 'beritum_delete',
            ],
            [
                'id'    => 40,
                'title' => 'beritum_access',
            ],
            [
                'id'    => 41,
                'title' => 'pengumuman_create',
            ],
            [
                'id'    => 42,
                'title' => 'pengumuman_edit',
            ],
            [
                'id'    => 43,
                'title' => 'pengumuman_show',
            ],
            [
                'id'    => 44,
                'title' => 'pengumuman_delete',
            ],
            [
                'id'    => 45,
                'title' => 'pengumuman_access',
            ],
            [
                'id'    => 46,
                'title' => 'rule_create',
            ],
            [
                'id'    => 47,
                'title' => 'rule_edit',
            ],
            [
                'id'    => 48,
                'title' => 'rule_show',
            ],
            [
                'id'    => 49,
                'title' => 'rule_delete',
            ],
            [
                'id'    => 50,
                'title' => 'rule_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
