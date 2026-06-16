<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Absensi;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard guru.
     */
    public function index(Request $request)
    {
        // 1. Ambil data guru yang login
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        // 2. Ambil data master untuk filter/statistik
        $kelasList     = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = $guru ? $guru->mataPelajaran : collect();

        // ---- Statistik Dashboard ----
        $totalSiswa = Siswa::count();
        $totalSiswaDinilai = 0;
        
        // Optimasi pencarian jumlah siswa dinilai (sesuaikan dengan skema database Anda)
        try {
            if (DB::getSchemaBuilder()->hasColumn('nilai', 'Siswaid_siswa')) {
                $totalSiswaDinilai = Nilai::distinct('Siswaid_siswa')->count('Siswaid_siswa');
            } else {
                $totalSiswaDinilai = Nilai::distinct('nama_siswa')->count('nama_siswa');
            }
        } catch (\Exception $e) {
            $totalSiswaDinilai = 0;
        }
        
        $progressNilai = $totalSiswa > 0 ? round(($totalSiswaDinilai / $totalSiswa) * 100) : 0;

        // Hitung rata-rata per kelas
        $kelasStats = $kelasList->map(function($k) {
            $rataRata = 0;
            try {
                // Gunakan skema kolom yang sesuai (nilai_angka atau nilai)
                $column = DB::getSchemaBuilder()->hasColumn('nilai', 'nilai_angka') ? 'nilai_angka' : 'nilai';
                
                if (DB::getSchemaBuilder()->hasColumn('nilai', 'kelas')) {
                    $avg = Nilai::where('kelas', $k->nama_kelas)->avg($column);
                } else {
                    $siswaIds = Siswa::where('Kelasid_kelas', $k->id_kelas)->pluck('id_siswa');
                    $avg = Nilai::whereIn('Siswaid_siswa', $siswaIds)->avg($column);
                }

                if ($avg) {
                    $rataRata = round($avg, 2);
                }
            } catch (\Exception $e) {
                // Abaikan jika error skema
            }
            
            return (object) [
                'nama_kelas' => $k->nama_kelas,
                'rata_rata'  => $rataRata,
            ];
        });

        // Filter dari query string
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');

        $kelasTerpilih = $selectedKelas ? Kelas::find($selectedKelas) : null;
        $siswa = $selectedKelas
            ? Siswa::where('Kelasid_kelas', $selectedKelas)->orderBy('nama_siswa')->get()
            : collect();

        // [PPLE-11] Ambil semua nilai tersimpan per siswa per jenis_nilai (untuk badge & tombol Edit)
        $nilaiTersimpanAll = [];
        if ($selectedKelas && $selectedMapel && $siswa->isNotEmpty()) {
            $siswaIds = $siswa->pluck('id_siswa');
            $semuaNilai = Nilai::whereIn('Siswaid_siswa', $siswaIds)
                ->where('Mata_Pelajaranid_mapel', $selectedMapel)
                ->get();
            foreach ($semuaNilai as $n) {
                $nilaiTersimpanAll[$n->Siswaid_siswa][$n->jenis_nilai] = $n;
            }
        }

        return view('dashboard', compact(
            'guru',
            'kelasList',
            'mataPelajaran',
            'totalSiswa',
            'totalSiswaDinilai',
            'progressNilai',
            'kelasStats',
            'selectedKelas',
            'selectedMapel',
            'kelasTerpilih',
            'siswa',
            'nilaiTersimpanAll'
        ));
    }

    /**
     * Halaman Input Nilai (Terpisah).
     */
    public function inputNilai(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $kelasList     = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = $guru ? $guru->mataPelajaran : MataPelajaran::orderBy('nama_mapel')->get();

        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');

        $kelasTerpilih = $selectedKelas ? Kelas::find($selectedKelas) : null;
        $siswa = $selectedKelas
            ? Siswa::where('Kelasid_kelas', $selectedKelas)->orderBy('nama_siswa')->get()
            : collect();

        $nilaiTersimpanAll = [];
        if ($selectedKelas && $selectedMapel && $siswa->isNotEmpty()) {
            $siswaIds = $siswa->pluck('id_siswa');
            $semuaNilai = Nilai::whereIn('Siswaid_siswa', $siswaIds)
                ->where('Mata_Pelajaranid_mapel', $selectedMapel)
                ->get();
                
            foreach ($semuaNilai as $n) {
                $nilaiTersimpanAll[$n->Siswaid_siswa][$n->jenis_nilai] = $n;
            }
        }

        return view('input-nilai', compact(
            'kelasList',
            'mataPelajaran',
            'siswa',
            'selectedKelas',
            'selectedMapel',
            'kelasTerpilih',
            'guru',
            'nilaiTersimpanAll'
        ));
    }

    /**
     * Form pilih mata pelajaran
     */
    public function selectMapel()
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $mataPelajaranDiampu = [];
        $semuaMataPelajaran  = MataPelajaran::orderBy('nama_mapel')->get();

        return view('dashboard-select-mapel', compact(
            'guru',
            'mataPelajaranDiampu',
            'semuaMataPelajaran'
        ));
    }

    /**
     * Simpan mapel yang diampu
     */
    public function storeMapel(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan.');
        }

        $validated = $request->validate([
            'mata_pelajaran_ids'   => 'required|array|min:1',
            'mata_pelajaran_ids.*' => 'exists:mata_pelajaran,id_mapel', // Pastikan nama tabel di DB tepat 'mata_pelajaran'
        ], [
            'mata_pelajaran_ids.required' => 'Mata pelajaran wajib dipilih minimal satu.',
            'mata_pelajaran_ids.min'      => 'Mata pelajaran wajib dipilih minimal satu.',
        ]);

        $guru->mataPelajaran()->sync($validated['mata_pelajaran_ids']);

        return redirect()->route('dashboard')
            ->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    /**
     * Halaman kelola siswa
     */
    public function manageStudents(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $selectedMapel = $request->get('mapel_id');
        $selectedKelas = $request->get('kelas_id');

        // Proteksi jika data guru atau relasi mapel tidak ditemukan
        if ($selectedMapel && $guru) {
            $isAllowed = $guru->mataPelajaran()
                ->where('id_mapel', $selectedMapel)
                ->exists();

            if (!$isAllowed) {
                return back()->with('error', 'Tidak berhak akses mapel ini!');
            }
        }

        $mataPelajaran = $guru ? $guru->mataPelajaran : collect();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        $siswa = collect();
        if ($selectedKelas && $selectedMapel) {
            $siswa = Siswa::with('kelas')
                ->where('Kelasid_kelas', $selectedKelas)
                ->orderBy('nama_siswa')
                ->get();
        }

        $kelasTerpilih = $selectedKelas ? Kelas::find($selectedKelas) : null;
        $mapelTerpilih = $selectedMapel ? MataPelajaran::find($selectedMapel) : null;

        return view('dashboard-manage-students', compact(
            'guru',
            'mataPelajaran',
            'kelas',
            'siswa',
            'selectedMapel',
            'selectedKelas',
            'kelasTerpilih',
            'mapelTerpilih'
        ));
    }

    /**
     * Detail siswa
     */
    public function studentDetail(Request $request, $id)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $siswa = Siswa::with('kelas')->findOrFail($id);

        $selectedMapel = $request->get('mapel_id');
        $selectedKelas = $siswa->Kelasid_kelas;

        if ($selectedMapel && $guru) {
            $isAllowed = $guru->mataPelajaran()
                ->where('id_mapel', $selectedMapel)
                ->exists();

            if (!$isAllowed) {
                return back()->with('error', 'Tidak berhak akses siswa ini!');
            }
        }

        $mapelIds = $guru ? $guru->mataPelajaran->pluck('id_mapel') : collect();

        $nilaiList = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
            ->whereIn('Mata_Pelajaranid_mapel', $mapelIds)
            ->with('mataPelajaran')
            ->get();

        $nilaiMapel = null;
        if ($selectedMapel) {
            $nilaiMapel = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
                ->where('Mata_Pelajaranid_mapel', $selectedMapel)
                ->first();
        }

        $absensi = Absensi::where('Siswaid_siswa', $siswa->id_siswa)->first();
        $mataPelajaran = $guru ? $guru->mataPelajaran : collect();
        $kelas = Kelas::all();

        return view('dashboard-student-detail', compact(
            'guru',
            'siswa',
            'nilaiList',
            'nilaiMapel',
            'absensi',
            'mataPelajaran',
            'kelas',
            'selectedMapel',
            'selectedKelas'
        ));
    }
}