<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\Rapor;

class RaporController extends Controller
{
    /**
     * Tampilkan halaman daftar siswa untuk dicetak rapornya
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $selectedKelas = $request->get('kelas_id');

        $siswa = collect();
        if ($selectedKelas) {
            $siswa = Siswa::with('kelas')
                ->where('Kelasid_kelas', $selectedKelas)
                ->orderBy('nama_siswa')
                ->get();
        }

        return view('admin.rapor.index', compact('kelasList', 'siswa', 'selectedKelas'));
    }

    /**
     * Generate file rapor PDF dan simpan ke arsip
     */
    public function generatePdf($id_siswa)
    {
        // Menarik data siswa menggunakan Eager Loading untuk Kelas, Nilai, dan Absensi
        $siswa = Siswa::with(['kelas', 'nilai.mataPelajaran', 'absensi'])
                      ->findOrFail($id_siswa);
        
        // Ambil nilai beserta mata pelajaran dari relasi
        $nilaiList = $siswa->nilai;

        // Ambil absensi terbaru dari relasi
        $absensi = $siswa->absensi->first();

        // Hitung nilai akhir (rata-rata)
        $rataRata = $nilaiList->avg('nilai_angka') ?? 0;

        $data = [
            'siswa' => $siswa,
            'nilaiList' => $nilaiList,
            'absensi' => $absensi,
            'tahun_pelajaran' => '2025/2026',
            'semester' => 1
        ];

        // Load view PDF
        $pdf = Pdf::loadView('admin.rapor.template_pdf', $data)
            ->setPaper('A4', 'portrait');

        // Buat nama file yang unik
        $fileName = 'Rapor_' . str_replace(' ', '_', $siswa->nama_siswa) . '_' . time() . '.pdf';
        $filePath = 'arsip_rapor/' . $fileName;

        // Simpan file PDF ke storage/app/public/arsip_rapor
        Storage::disk('public')->put($filePath, $pdf->output());

        // Simpan data rapor ke database sebagai riwayat/arsip
        Rapor::create([
            'nilai_akhir' => round($rataRata),
            'Siswaid_siswa' => $siswa->id_siswa,
            'file_path' => $filePath,
            'mata_pelajaran' => 'Rapor'
        ]);

        // Kembalikan file PDF langsung sebagai response unduhan (Download otomatis)
        return $pdf->download($fileName);
    }

    /**
     * Tampilkan halaman daftar arsip rapor
     */
    public function arsip()
    {
        // Mengambil semua arsip rapor terbaru
        $rapors = Rapor::with('siswa.kelas')->orderBy('created_at', 'desc')->get();
        return view('admin.rapor.arsip', compact('rapors'));
    }

    /**
     * Download file PDF dari arsip
     */
    public function download($id_rapor)
    {
        $rapor = Rapor::findOrFail($id_rapor);
        
        if (Storage::disk('public')->exists($rapor->file_path)) {
            return Storage::disk('public')->download($rapor->file_path);
        }

        return back()->with('error', 'File PDF tidak ditemukan di server.');
    }
}
