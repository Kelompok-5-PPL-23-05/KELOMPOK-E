<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\Rapor;
use Illuminate\Support\Facades\Storage;

class RaporTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_generate_and_archive_rapor()
    {
        // Mock disk public
        Storage::fake('public');

        // 1. Buat User Admin & Guru
        $admin = User::create([
            'username' => 'admin_test',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        $userGuru = User::create([
            'username' => 'guru_test',
            'password' => bcrypt('password'),
            'role' => 'guru'
        ]);

        $guru = Guru::create([
            'Userid_user' => $userGuru->id_user,
            'nama_guru' => 'Bapak Guru Test'
        ]);

        // 2. Buat Kelas & Siswa
        $kelas = Kelas::create(['nama_kelas' => 'Paket B Kelas 1']);
        
        $siswa = Siswa::create([
            'nama_siswa' => 'Budi Santoso',
            'Kelasid_kelas' => $kelas->id_kelas
        ]);

        // 3. Buat Mata Pelajaran & Nilai
        $mapel = MataPelajaran::create(['nama_mapel' => 'Matematika']);
        
        Nilai::create([
            'nilai_angka' => 85,
            'deskripsi' => 'Sangat baik',
            'Siswaid_siswa' => $siswa->id_siswa,
            'Guruid_guru' => $guru->id_guru,
            'Mata_Pelajaranid_mapel' => $mapel->id_mapel
        ]);

        // 4. Buat Absensi
        Absensi::create([
            'hadir' => 20,
            'sakit' => 1,
            'izin' => 2,
            'alfa' => 0,
            'Siswaid_siswa' => $siswa->id_siswa
        ]);

        // 5. Jalankan generatePdf sebagai admin
        $response = $this->actingAs($admin)
            ->post(route('rapor.generate', $siswa->id_siswa));

        // Assert redirect ke halaman arsip
        $response->assertRedirect(route('rapor.arsip'));
        $response->assertSessionHas('success');

        // 6. Assert data tersimpan ke database rapor
        $this->assertDatabaseHas('rapor', [
            'Siswaid_siswa' => $siswa->id_siswa,
            'nilai_akhir' => 85,
        ]);

        $rapor = Rapor::where('Siswaid_siswa', $siswa->id_siswa)->first();
        $this->assertNotNull($rapor);
        $this->assertNotNull($rapor->file_path);

        // 7. Assert file PDF tersimpan di storage public
        Storage::disk('public')->assertExists($rapor->file_path);

        // 8. Test download file rapor
        $downloadResponse = $this->actingAs($admin)
            ->get(route('rapor.download', $rapor->id_rapor));

        $downloadResponse->assertStatus(200);
        $downloadResponse->assertHeader('content-disposition', 'attachment; filename=' . basename($rapor->file_path));
    }
}
