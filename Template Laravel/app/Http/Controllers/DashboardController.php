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
     * Tampilkan halaman dashboard/homepage
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ambil data guru yang login
        $guru = Guru::where('Userid_user', $user->id_user)->first();
        
        // Jika user adalah guru, tampilkan hanya mata pelajaran yang diampu
        if ($user->role === 'guru' && $guru) {
            $mataPelajaran = $guru->mataPelajaran; // Dari relasi many-to-many
        } else {
            $mataPelajaran = MataPelajaran::all();
        }

        $kelas = Kelas::all();
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');

        $siswa = [];
        if ($selectedKelas) {
            $siswa = Siswa::where('Kelasid_kelas', $selectedKelas)->get();
        }

        return view('dashboard', compact('kelas', 'mataPelajaran', 'siswa', 'selectedKelas', 'selectedMapel', 'guru'));
    }

    /**
     * Tampilkan form untuk memilih mata pelajaran yang diampu
     */
    public function selectMapel()
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();
        $mataPelajaranDiampu = $guru->mataPelajaran()->pluck('id_mapel')->toArray();
        $semuaMataPelajaran = MataPelajaran::all();

        return view('dashboard-select-mapel', compact('guru', 'mataPelajaranDiampu', 'semuaMataPelajaran'));
    }

    /**
     * Simpan pilihan mata pelajaran yang diampu
     */
    public function storeMapel(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $validated = $request->validate([
            'mata_pelajaran_ids' => 'required|array|min:1',
            'mata_pelajaran_ids.*' => 'exists:mata_pelajaran,id_mapel',
        ]);

        // Sync (update) relasi many-to-many
        $guru->mataPelajaran()->sync($validated['mata_pelajaran_ids']);

        return redirect()->route('dashboard')
            ->with('success', 'Mata pelajaran yang diampu berhasil diperbarui!');
    }

    /**
     * Tampilkan data siswa berdasarkan mata pelajaran yang dipilih
     */
    public function manageStudents(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();
        
        $selectedMapel = $request->get('mapel_id');
        $selectedKelas = $request->get('kelas_id');

        // Validasi: guru hanya bisa lihat mata pelajaran yang diampu
        if ($selectedMapel) {
            $isAllowed = $guru->mataPelajaran()
                ->where('id_mapel', $selectedMapel)
                ->exists();

            if (!$isAllowed) {
                return back()->with('error', 'Anda tidak berhak mengakses mata pelajaran ini!');
            }
        }

        $mataPelajaran = $guru->mataPelajaran;
        $kelas = Kelas::all();
        
        $siswa = [];
        if ($selectedKelas) {
            $siswa = Siswa::where('Kelasid_kelas', $selectedKelas)->get();
        }

        return view('dashboard-manage-students', compact('guru', 'mataPelajaran', 'siswa', 'kelas', 'selectedMapel', 'selectedKelas'));
    }

    /**
     * Tampilkan detail siswa: info, nilai per mapel, dan absensi
     */
    public function studentDetail(Request $request, $id)
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $siswa = Siswa::with(['kelas'])->findOrFail($id);

        $selectedMapel = $request->get('mapel_id');
        $selectedKelas = $siswa->Kelasid_kelas;

        // Validasi: guru hanya bisa lihat siswa dari mapel yang diampu
        if ($selectedMapel) {
            $isAllowed = $guru->mataPelajaran()
                ->where('id_mapel', $selectedMapel)
                ->exists();

            if (!$isAllowed) {
                return back()->with('error', 'Anda tidak berhak mengakses data siswa ini!');
            }
        }

        // Ambil nilai siswa untuk mapel yang dipilih (atau semua mapel yang diampu guru)
        $mapelIds = $guru->mataPelajaran->pluck('id_mapel');
        $nilaiList = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
            ->whereIn('Mata_Pelajaranid_mapel', $mapelIds)
            ->with('mataPelajaran')
            ->get();

        // Jika ada filter mapel spesifik, ambil hanya yang itu
        $nilaiMapel = null;
        if ($selectedMapel) {
            $nilaiMapel = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
                ->where('Mata_Pelajaranid_mapel', $selectedMapel)
                ->first();
        }

        // Absensi siswa
        $absensi = Absensi::where('Siswaid_siswa', $siswa->id_siswa)->first();

        $mataPelajaran = $guru->mataPelajaran;
        $kelas         = Kelas::all();

        return view('dashboard-student-detail', compact(
            'guru', 'siswa', 'nilaiList', 'nilaiMapel',
            'absensi', 'mataPelajaran', 'kelas',
            'selectedMapel', 'selectedKelas'
        ));
    }
}
