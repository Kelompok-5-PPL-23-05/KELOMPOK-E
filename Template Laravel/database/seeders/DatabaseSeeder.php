<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Buat akun admin default
        $this->call(AdminSeeder::class);

        // 1. Buat User Guru jika belum ada, atau ambil yang existing
        $userGuru = User::firstOrCreate(
            ['username' => 'Guru1'],
            [
                'password' => Hash::make('Guru123'),
                'role' => 'guru'
            ]
        );

        // 2. Buat Data Guru terkait 
        $guru = Guru::firstOrCreate(
            ['Userid_user' => $userGuru->id_user],
            [
                'nama_guru' => 'Bapak Guru Satu'
            ]
        );

        // 3. Buat Data Kelas
        $kelasA3 = Kelas::firstOrCreate(['nama_kelas' => 'Paket A Kelas 3']);
        $kelasB1 = Kelas::firstOrCreate(['nama_kelas' => 'Paket B Kelas 1']);
        $kelasC2 = Kelas::firstOrCreate(['nama_kelas' => 'Paket C Kelas 2']);

        // 4. Buat Data Mata Pelajaran
        $bahasaIndonesia = MataPelajaran::firstOrCreate(['nama_mapel' => 'Bahasa Indonesia']);
        $bahasaInggris = MataPelajaran::firstOrCreate(['nama_mapel' => 'Bahasa Inggris']);
        $matematika = MataPelajaran::firstOrCreate(['nama_mapel' => 'Matematika']);

        // 5. Attach mata pelajaran ke guru (relasi many-to-many)
        // Guru1 mengampu Bahasa Indonesia dan Matematika
        $guru->mataPelajaran()->syncWithoutDetaching([
            $bahasaIndonesia->id_mapel,
            $matematika->id_mapel
        ]);

        // 6. Buat Data Siswa untuk Kelas 'Paket A Kelas 3'
        $siswaData = [
            'Agus Setiawan',
            'Budi Santoso',
            'Citra Lestari',
        ];

        foreach ($siswaData as $nama) {
            Siswa::firstOrCreate(
                ['nama_siswa' => $nama],
                [
                    'Kelasid_kelas' => $kelasA3->id_kelas
                ]
            );
        }
    }
}
