<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard guru.
     * Guru memilih kelas via dropdown; daftar siswa difilter berdasarkan kelas terpilih.
     */
    public function index(Request $request)
    {
        // Ambil semua kelas dan mata pelajaran dari DB untuk mengisi dropdown
        $kelasList    = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        // Pilihan dari query string (?kelas_id=x&mapel_id=y)
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');

        // Ambil data kelas terpilih (untuk heading / info)
        $kelasTerpilih = $selectedKelas
            ? Kelas::find($selectedKelas)
            : null;

        // Ambil siswa berdasarkan kelas terpilih; kosong jika belum memilih
        $siswa = $selectedKelas
            ? Siswa::where('Kelasid_kelas', $selectedKelas)->orderBy('nama_siswa')->get()
            : collect();

        return view('dashboard', compact(
            'kelasList',
            'mataPelajaran',
            'siswa',
            'selectedKelas',
            'selectedMapel',
            'kelasTerpilih'
        ));
    }
}
