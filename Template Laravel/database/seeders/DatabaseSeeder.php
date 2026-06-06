<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin
        User::firstOrCreate(
            ['username' => 'admin1'],
            [
<<<<<<< HEAD
<<<<<<< HEAD
                'password' => Hash::make('admin123'),
=======
                'password' => 'admin123',
>>>>>>> 6e3607fcc2cb29df7a40d006dc6b79cc9a0e21a1
=======
                'password' => Hash::make('admin123'),
>>>>>>> origin/main
                'role' => 'admin'
            ]
        );

        // 2. Buat User Guru
        $userGuru = User::firstOrCreate(
            ['username' => 'guru1'],
            [
<<<<<<< HEAD
<<<<<<< HEAD
                'password' => Hash::make('guru123'),
=======
                'password' => 'guru123',
>>>>>>> 6e3607fcc2cb29df7a40d006dc6b79cc9a0e21a1
=======
                'password' => Hash::make('guru123'),
>>>>>>> origin/main
                'role' => 'guru'
            ]
        );

        // 3. Buat Data Guru terkait
<<<<<<< HEAD
        $guru = Guru::firstOrCreate(
=======
        Guru::firstOrCreate(
>>>>>>> origin/main
            ['Userid_user' => $userGuru->id_user],
            [
                'nama_guru' => 'Bapak Guru Satu'
            ]
        );

        // 4. Buat Data Kelas
        $kelasA3 = Kelas::firstOrCreate(['nama_kelas' => 'Paket A Kelas 3']);
        $kelasB1 = Kelas::firstOrCreate(['nama_kelas' => 'Paket B Kelas 1']);
        $kelasC2 = Kelas::firstOrCreate(['nama_kelas' => 'Paket C Kelas 2']);

        // 5. Buat Data Mata Pelajaran
<<<<<<< HEAD
        $bahasaIndonesia = MataPelajaran::firstOrCreate(['nama_mapel' => 'Bahasa Indonesia']);
        $bahasaInggris   = MataPelajaran::firstOrCreate(['nama_mapel' => 'Bahasa Inggris']);
        $matematika      = MataPelajaran::firstOrCreate(['nama_mapel' => 'Matematika']);

        // 6. Attach mata pelajaran ke guru (relasi many-to-many)
        $guru->mataPelajaran()->syncWithoutDetaching([
            $bahasaIndonesia->id_mapel,
            $matematika->id_mapel
        ]);

        // 7. Buat Data Siswa — masing-masing di kelas berbeda
=======
        MataPelajaran::firstOrCreate(['nama_mapel' => 'Bahasa Indonesia']);
        MataPelajaran::firstOrCreate(['nama_mapel' => 'Bahasa Inggris']);
        MataPelajaran::firstOrCreate(['nama_mapel' => 'Matematika']);

        // 6. Buat Data Siswa
>>>>>>> origin/main
        Siswa::firstOrCreate(
            ['nama_siswa' => 'Agus Setiawan'],
            ['Kelasid_kelas' => $kelasA3->id_kelas]
        );

        Siswa::firstOrCreate(
            ['nama_siswa' => 'Budi Santoso'],
            ['Kelasid_kelas' => $kelasB1->id_kelas]
        );

        Siswa::firstOrCreate(
            ['nama_siswa' => 'Citra Lestari'],
            ['Kelasid_kelas' => $kelasC2->id_kelas]
        );
    }
}