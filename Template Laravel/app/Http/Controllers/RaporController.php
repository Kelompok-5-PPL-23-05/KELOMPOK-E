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
        $siswa = Siswa::with('kelas')->findOrFail($id_siswa);

        // Ambil semua nilai siswa beserta mata pelajaran
        $semuaNilai = Nilai::with('mataPelajaran')
            ->where('Siswaid_siswa', $id_siswa)
            ->get();

        // Kelompokkan per mata pelajaran, hitung nilai akhir
        $nilaiPerMapel = $semuaNilai
            ->groupBy('Mata_Pelajaranid_mapel')
            ->map(function ($nilaiMapel) {
                $uts   = $nilaiMapel->firstWhere('jenis_nilai', 'UTS');
                $uas   = $nilaiMapel->firstWhere('jenis_nilai', 'UAS');
                $tugas = $nilaiMapel->firstWhere('jenis_nilai', 'Tugas');

                $nilaiAkhir = null;
                if ($uts && $uas && $tugas) {
                    $nilaiAkhir = round(
                        ($uts->nilai_angka * 0.30) +
                        ($uas->nilai_angka * 0.30) +
                        ($tugas->nilai_angka * 0.40)
                    );
                } elseif ($uts || $uas || $tugas) {
                    // Jika belum lengkap, rata-rata yang ada saja
                    $nilaiAkhir = round($nilaiMapel->avg('nilai_angka'));
                }

                // Ambil deskripsi dari catatan yang tersedia
                $deskripsi = collect([$uts, $uas, $tugas])
                    ->filter()
                    ->pluck('deskripsi')
                    ->filter()
                    ->first() ?? '';

                return (object) [
                    'nama_mapel'  => optional($nilaiMapel->first()->mataPelajaran)->nama_mapel ?? '-',
                    'uts'         => $uts?->nilai_angka,
                    'uas'         => $uas?->nilai_angka,
                    'tugas'       => $tugas?->nilai_angka,
                    'nilai_akhir' => $nilaiAkhir,
                    'deskripsi'   => $deskripsi,
                    'lengkap'     => ($uts && $uas && $tugas),
                ];
            })->values();

        // Ambil absensi
        $absensi = Absensi::where('Siswaid_siswa', $id_siswa)->first();

        // Nilai akhir keseluruhan (rata-rata semua mapel)
        $rataRata = $nilaiPerMapel->avg('nilai_akhir') ?? 0;

        $data = [
            'siswa'           => $siswa,
            'nilaiList'       => $nilaiPerMapel,
            'absensi'         => $absensi,
            'tahun_pelajaran' => '2025/2026',
            'semester'        => 1,
        ];

        $pdf = Pdf::loadView('admin.rapor.template_pdf', $data)
            ->setPaper('A4', 'portrait');

        $fileName = 'Rapor_' . str_replace(' ', '_', $siswa->nama_siswa) . '_' . time() . '.pdf';
        $filePath = 'arsip_rapor/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        Rapor::create([
            'nilai_akhir'    => round($rataRata),
            'Siswaid_siswa'  => $siswa->id_siswa,
            'file_path'      => $filePath,
            'mata_pelajaran' => 'Rapor',
        ]);

        return redirect()->route('rapor.arsip')
            ->with('success', 'Rapor atas nama ' . $siswa->nama_siswa . ' berhasil di-generate dan diarsipkan!');
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

    /**
     * Cetak Rapor Siswa PDF secara langsung (Subtask 2)
     */
    public function cetakPdf($id_siswa)
    {
        $siswa = Siswa::with(['kelas', 'nilai.mataPelajaran', 'absensi'])->findOrFail($id_siswa);

        // Kelompokkan per mata pelajaran, hitung nilai akhir
        $nilaiPerMapel = $siswa->nilai
            ->groupBy('Mata_Pelajaranid_mapel')
            ->map(function ($nilaiMapel) {
                $uts   = $nilaiMapel->firstWhere('jenis_nilai', 'UTS');
                $uas   = $nilaiMapel->firstWhere('jenis_nilai', 'UAS');
                $tugas = $nilaiMapel->firstWhere('jenis_nilai', 'Tugas');

                $nilaiAkhir = null;
                if ($uts && $uas && $tugas) {
                    $nilaiAkhir = round(
                        ($uts->nilai_angka * 0.30) +
                        ($uas->nilai_angka * 0.30) +
                        ($tugas->nilai_angka * 0.40)
                    );
                } elseif ($uts || $uas || $tugas) {
                    $nilaiAkhir = round($nilaiMapel->avg('nilai_angka'));
                }

                $deskripsi = collect([$uts, $uas, $tugas])
                    ->filter()
                    ->pluck('deskripsi')
                    ->filter()
                    ->first() ?? '';

                return (object) [
                    'nama_mapel'  => optional($nilaiMapel->first()->mataPelajaran)->nama_mapel ?? '-',
                    'uts'         => $uts?->nilai_angka,
                    'uas'         => $uas?->nilai_angka,
                    'tugas'       => $tugas?->nilai_angka,
                    'nilai_akhir' => $nilaiAkhir,
                    'deskripsi'   => $deskripsi,
                    'lengkap'     => ($uts && $uas && $tugas),
                ];
            })->values();

        $data = [
            'siswa'           => $siswa,
            'nilaiList'       => $nilaiPerMapel,
            'absensi'         => $siswa->absensi->first(),
            'tahun_pelajaran' => '2025/2026',
            'semester'        => 1,
        ];

        $pdf = Pdf::loadView('admin.rapor.template_pdf', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('Rapor_' . str_replace(' ', '_', $siswa->nama_siswa) . '.pdf');
    }
}
