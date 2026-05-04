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

        // Dropdown data
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

        return view('dashboard', compact(
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
     */
    public function selectMapel()
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        $mataPelajaranDiampu = $guru->mataPelajaran()->pluck('id_mapel')->toArray();
        $semuaMataPelajaran  = MataPelajaran::all();

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

        $validated = $request->validate([
            'mata_pelajaran_ids'   => 'required|array|min:1',
            'mata_pelajaran_ids.*' => 'exists:mata_pelajaran,id_mapel',
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