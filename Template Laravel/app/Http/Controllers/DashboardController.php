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
     * Guru memilih kelas dan mata pelajaran via dropdown; daftar siswa difilter.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil data guru yang login
        $guru = Guru::where('Userid_user', $user->id_user)->first();

        // Ambil semua kelas dan mata pelajaran dari DB untuk mengisi dropdown
        $kelasList     = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = $guru
            ? $guru->mataPelajaran
            : MataPelajaran::orderBy('nama_mapel')->get();

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
            'kelasTerpilih',
            'guru'
        ));
    }

    /**
     * Tampilkan form untuk memilih mata pelajaran yang diampu
     */
    public function selectMapel()
    {
        $user = Auth::user();
        $guru = Guru::where('Userid_user', $user->id_user)->first();
        $mataPelajaranDiampu = $guru->mataPelajaran()->pluck('id_mapel')->toArray();
        $semuaMataPelajaran  = MataPelajaran::all();

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
            'mata_pelajaran_ids'   => 'required|array|min:1',
            'mata_pelajaran_ids.*' => 'exists:mata_pelajaran,id_mapel',
        ]);

        // Sync (update) relasi many-to-many
        $guru->mataPelajaran()->sync($validated['mata_pelajaran_ids']);

        return redirect()->route('dashboard')
            ->with('success', 'Mata pelajaran yang diampu berhasil diperbarui!');
    }

    /**
     * Tampilkan daftar siswa berdasarkan kelas dan mata pelajaran yang dipilih.
     * Subtask 1 : Query siswa berdasarkan kelas
     * Subtask 2 : Tampilkan tabel siswa
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

        // Daftar mapel yang diampu guru (untuk dropdown filter)
        $mataPelajaran = $guru->mataPelajaran;

        // Semua kelas (untuk dropdown filter)
        $kelas = Kelas::orderBy('nama_kelas')->get();

        // ── Subtask 1: Query siswa berdasarkan kelas ──────────────────────────
        // Jika kelas sudah dipilih, ambil siswa dari kelas tersebut beserta
        // relasi kelas-nya (eager load) agar kolom "Kelas" di tabel terisi.
        $siswa = collect();
        if ($selectedKelas) {
            $siswa = Siswa::with('kelas')
                ->where('Kelasid_kelas', $selectedKelas)
                ->orderBy('nama_siswa')
                ->get();
        }

        // Informasi kelas & mapel terpilih (untuk heading tabel)
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

        // Ambil nilai siswa untuk mapel yang diampu guru
        $mapelIds  = $guru->mataPelajaran->pluck('id_mapel');
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
