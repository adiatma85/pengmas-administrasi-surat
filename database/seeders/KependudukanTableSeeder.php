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
                'fullname' => 'Masyarat 1 testing',
                'nik' => 'NIK yang panjang dan lebar',
                'birthdate' => '2001-09-27',
                'birthplace' => 'Subaraya',
                'gender' => 'LAKI_LAKI',
                'religion' => 'ISLAM',
                'marital_status' => 'KAWIN',
                'latest_education' => 'SLTA',
                'occupation' => 'Mahasiswa',
                'father_name' => 'Ini nama ayah',
                'mother_name' => 'Ini nama ibu',
                'disease' => 'Tidak ada penyakit',

                // Add on
                'user_id' => 3
            ]
        ];

        Kependudukan::insert($kependudukans);
    }
}
