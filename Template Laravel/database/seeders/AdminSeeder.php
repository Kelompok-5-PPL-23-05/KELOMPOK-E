<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Buat akun admin default untuk E-Rapor PKBM
     */
    public function run(): void
    {
        // Cek dulu apakah admin sudah ada, hindari duplikasi
        $adminSudahAda = User::where('username', 'admin')->exists();

        if (!$adminSudahAda) {
            User::create([
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]);

            $this->command->info('✅ Akun admin berhasil dibuat!');
            $this->command->info('   Username : admin');
            $this->command->info('   Password : admin123');
            $this->command->warn('   ⚠ Segera ganti password setelah login pertama!');
        } else {
            $this->command->warn('⚠ Akun admin sudah ada, seeder dilewati.');
        }
    }
}
