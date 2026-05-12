<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();

        // Ambil data guru yang login
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        // Ambil semua kelas dan mata pelajaran dari DB untuk statistik
        $kelasList     = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = $guru
            ? $guru->mataPelajaran
            : collect();

        // ---- Statistik Dashboard ----
        $totalSiswa = Siswa::count();
        $totalSiswaDinilai = 0;
        
        try {
            // Jika menggunakan tabel 'nilai' (dengan relasi FK id_siswa)
            $totalSiswaDinilai = Nilai::distinct('Siswaid_siswa')->count('Siswaid_siswa');
        } catch (\Exception $e) {
            // Jika menggunakan tabel 'nilais' (dengan kolom nama_siswa string)
            try {
                $totalSiswaDinilai = Nilai::distinct('nama_siswa')->count('nama_siswa');
            } catch (\Exception $e2) {
                $totalSiswaDinilai = 0;
            }
        }
        
        $progressNilai = $totalSiswa > 0 ? round(($totalSiswaDinilai / $totalSiswa) * 100) : 0;

        $kelasStats = Kelas::all()->map(function($k) {
            $rataRata = 0;
            
            try {
                // Mengambil nilai rata-rata dari tabel nilais (yang menggunakan kolom string 'kelas')
                $avg = Nilai::where('kelas', $k->nama_kelas)->avg('nilai');
                if ($avg) {
                    $rataRata = round($avg, 2);
                }
            } catch (\Exception $e) {
                // Jika tabelnya berbeda (misal menggunakan FK id_siswa di tabel nilai)
                try {
                    $siswaIds = Siswa::where('Kelasid_kelas', $k->id_kelas)->pluck('id_siswa');
                    $avg = \Illuminate\Support\Facades\DB::table('nilai')->whereIn('Siswaid_siswa', $siswaIds)->avg('nilai_angka');
                    if ($avg) {
                        $rataRata = round($avg, 2);
                    }
                } catch (\Exception $e2) {
                    // Abaikan jika error
                }
            }
            
            return (object) [
                'nama_kelas' => $k->nama_kelas,
                'rata_rata' => $rataRata,
            ];
        });

        return view('dashboard', compact(
            'guru',
            'kelasList',
            'mataPelajaran',
            'totalSiswa',
            'totalSiswaDinilai',
            'progressNilai',
            'kelasStats'
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
        $mataPelajaran = $guru
            ? $guru->mataPelajaran
            : MataPelajaran::orderBy('nama_mapel')->get();

        // Filter
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');

        $kelasTerpilih = $selectedKelas
            ? Kelas::find($selectedKelas)
            : null;

        $siswa = $selectedKelas
            ? Siswa::where('Kelasid_kelas', $selectedKelas)->orderBy('nama_siswa')->get()
            : collect();

        return view('input-nilai', compact(
            'kelasList',
            'mataPelajaran',
            'siswa',
            'selectedKelas',
            'selectedMapel',
            'kelasTerpilih',
            'guru'
        ));
    }

    /**
     * Form pilih mata pelajaran
     * Subtask: Buat dropdown mapel
     * Subtask: Ambil data mapel dari database
     */
    public function selectMapel()
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        // Ambil data mapel dari database
        $mataPelajaranDiampu = $guru->mataPelajaran()->pluck('id_mapel')->toArray();
        $semuaMataPelajaran  = MataPelajaran::all();

        // View yang menampilkan dropdown mapel
        return view('dashboard-select-mapel', compact(
            'guru',
            'mataPelajaranDiampu',
            'semuaMataPelajaran'
        ));
    }

    /**
     * Simpan mapel yang diampu
     * Subtask: Simpan pilihan mapel
     */
    public function storeMapel(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $validated = $request->validate([
            'mata_pelajaran_ids'   => 'required|array|min:1',
            'mata_pelajaran_ids.*' => 'exists:mata_pelajaran,id_mapel',
        ]);

        // Simpan pilihan mapel ke database (sync relasi)
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

        // Validasi mapel
        if ($selectedMapel) {
            $isAllowed = $guru->mataPelajaran()
                ->where('id_mapel', $selectedMapel)
                ->exists();

            if (!$isAllowed) {
                return back()->with('error', 'Tidak berhak akses mapel ini!');
            }
        }

        $mataPelajaran = $guru->mataPelajaran;
        $kelas = Kelas::orderBy('nama_kelas')->get();

        // Ambil siswa
        $siswa = collect();
        if ($selectedKelas) {
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

        // Validasi akses mapel
        if ($selectedMapel) {
            $isAllowed = $guru->mataPelajaran()
                ->where('id_mapel', $selectedMapel)
                ->exists();

            if (!$isAllowed) {
                return back()->with('error', 'Tidak berhak akses siswa ini!');
            }
        }

        $mapelIds = $guru->mataPelajaran->pluck('id_mapel');

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

        $mataPelajaran = $guru->mataPelajaran;
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