<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaAsliSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kelas
        $kelasA = Kelas::where('nama_kelas', 'Paket A Kelas 3')->first();
        $kelasB = Kelas::where('nama_kelas', 'Paket B Kelas 1')->first();
        $kelasC = Kelas::where('nama_kelas', 'Paket C Kelas 2')->first();

        // Jika kelas tidak ditemukan, jangan lanjutkan
        if (!$kelasA || !$kelasB || !$kelasC) {
            $this->command->error('Kelas Paket A, B, atau C tidak ditemukan di database. Pastikan DatabaseSeeder sudah dijalankan sebelumnya.');
            return;
        }

        // --- DATA PAKET A ---
        $siswaPaketA = [
            'ABDUL GHANI AL HANIF', 'AHMAD', 'AISYAH', 'AISYAH AL HUMAIRA', 'AMINAH NURUL WAFA',
            'ATHAYA MUTIARA JANNAH', 'FADHLATUN NISSA', 'FAQIH MAULANA YUSUF', 'FATAH SAKHI SYAHEDA',
            'FATHIMAH AZZAHRA', 'FATIH SAKHA SYAHEDA', 'FATIMAH DWI HERIYANI', 'HABIB MUHAMAD IQBAL',
            'HAKIM ILHAM RAMADHAN', 'HANI FUADY', 'IRBADH', 'MUHAMMAD AHSAN', 'NAJWA PUTRI MUSTAWAN',
            'RAYHANA', 'RISKI', 'SAVAANA RAMADHANI', 'SHIFA NUR FAJRIYAH', 'SOFIA KHAIRUNNISA',
            'SYARIF ABDULLAH FATHURRAHMAN', 'TALITHA SYARAFANA', 'UMAR ABDUL AZIZ', 'ABDURRAHMAN FAIZ',
            'ADEEVA RIZQY SALSABILA', "Faruq 'Abdurrahman Fa'iq", 'FATIMATUZ ZAHRO', 'FEBRIANSYAH SUHERMAN',
            'IBROHIM', 'IBROHIM', 'KANAYA AYUDYA AZZAHRA', 'MUHAMMAD UMAR', 'MUHAMMAD USTMAN', 'MUTIARA MALIKA'
        ];

        foreach ($siswaPaketA as $nama) {
            Siswa::firstOrCreate([
                'nama_siswa' => $nama,
                'Kelasid_kelas' => $kelasA->id_kelas
            ]);
        }

        // --- DATA PAKET B ---
        $siswaPaketB = [
            'ABDUL AZIZ AL-', 'AISYAH', 'ANNISAH ZULFA', 'ASYA MIQYAL', 'ERSYAH JAMILAH',
            'FATHIMAH ZAHRA', 'HIMAYAH', 'KHADIJAH', 'KHAIRA AQILAH PERMATA BANDI', 'KHANSA IRWANCE',
            'LAILATUL', 'LAYYA KHUMAIS', 'LOVIONA NURWANDA', 'MASYITOH', 'MUHAMMAD HAFIDZ ABDULLAH',
            'Muhammad Rizky Aprillyansyah', 'NUR AISYAH', 'NUR HAMNAH', 'QIARA GIESTIA', 'RATU ZAINAB',
            'SAHLA IRAWAN', 'SALSABILA', 'SAUDAH', 'SHOFIYYAH', 'SYAFAA', 'UMAMAH IRWANCE',
            'AHBIEB ADIARTYA', 'AISYAH DHIYA', 'ASSYIFA QANITA', 'ATHAR MUSYAFFA', 'Dhiya Ulhaq Fadliawan',
            'DZULQARNAIN', 'FAKHIRA FAUZIAH', 'FAUZAN ADSAN', 'GHAZIYAH', 'Ghibran Farabi', 'HAASYIM AL GHIFARI'
        ];

        foreach ($siswaPaketB as $nama) {
            Siswa::firstOrCreate([
                'nama_siswa' => $nama,
                'Kelasid_kelas' => $kelasB->id_kelas
            ]);
        }

        // --- DATA PAKET C ---
        $siswaPaketC = [
            'ADAM', 'AIMA YUMNA', 'ATHIYYAH', 'CHYKA AULYA', 'DZULHILMI HARRAZ', 'Faiz Abdul Aziz',
            'FATHAN ABDILLAH MAULUDIN', 'FATURULLAH SYAH MAULUDIN', 'JENITA LUSIYANA', 'JUNIAR',
            'MUHAMMAD FIRAAS EL ACKYLA', 'MUHAMMAD LUTFI NERAZZURI', "MUTHI'AH", 'NATASYA WIDYATRI',
            'RAHAJENG HAMIDAH ADZ DZAKIYAH', 'RIZKY ARDIANSYAH', 'SAJIDAN ZAKIYYAN', 'SAVINA ANJANI PUTRI',
            'SYAHIDAH AMANIA', 'TUBAGUS AHMAD', 'ARIYA EKA SYAH PUTRA MULYANA', 'MUHAMMAD RAKY',
            'SITI MULYANI', 'DESI AYU', 'FARDAN ALDINUR', 'MUHAMMAD RIFKI', 'REISYA FITRI AULIA',
            'SAFFAANAH ILMI', 'SALMA NAILA HANIN', 'SINTA FITRIANTI', 'SUPRIATNA'
        ];

        foreach ($siswaPaketC as $nama) {
            Siswa::firstOrCreate([
                'nama_siswa' => $nama,
                'Kelasid_kelas' => $kelasC->id_kelas
            ]);
        }

        $this->command->info('✅ Seluruh data siswa asli (Paket A, B, C) berhasil dimasukkan ke database!');
    }
}
