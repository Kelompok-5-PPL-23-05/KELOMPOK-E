<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = [
            ['nama_kelas' => 'Paket A Kelas 1'],
            ['nama_kelas' => 'Paket A Kelas 2'],
            ['nama_kelas' => 'Paket A Kelas 3'],
            ['nama_kelas' => 'Paket B Kelas 1'],
            ['nama_kelas' => 'Paket B Kelas 2'],
            ['nama_kelas' => 'Paket B Kelas 3'],
            ['nama_kelas' => 'Paket C Kelas 1'],
            ['nama_kelas' => 'Paket C Kelas 2'],
            ['nama_kelas' => 'Paket C Kelas 3'],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }
    }
}
