<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kependudukan;
use Illuminate\Database\Seeder;

class KependudukanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kependudukans = [
            [
                'fullname' => 'Syafiq Faray',
                'nik' => '195150701111008',
                'birthdate' => '2001-09-27',
                'birthplace' => 'Subaraya',
                'gender' => 'LAKI_LAKI',
                'religion' => 'ISLAM',
                'marital_status' => 'KAWIN',
                'latest_education' => 'SLTA',
                'occupation' => 'Mahasiswa',
                'father_name' => 'Faray Muhammad',
                'mother_name' => 'Ibu Faray Muhammad',
                'disease' => 'Tidak ada penyakit',

                // Add on
                'user_id' => 3,
                // Ayah
                'father_religion' => 'ISLAM',
                'father_occupation' => 'Pengrajin',
                'mother_religion' => 'ISLAM',
                'mother_occupation' => 'Pengrajin',
            ]
        ];

        Kependudukan::insert($kependudukans);
    }
}
