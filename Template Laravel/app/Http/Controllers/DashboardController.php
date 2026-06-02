<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Nilai;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard guru.
     */
    public function index(Request $request)
    {
        $kelasList     = Kelas::orderBy('nama_kelas')->get();
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');

        $kelasTerpilih = $selectedKelas ? Kelas::find($selectedKelas) : null;

        $siswa = $selectedKelas
            ? Siswa::where('Kelasid_kelas', $selectedKelas)->orderBy('nama_siswa')->get()
            : collect();

        // Ambil data guru yang terhubung ke user yang sedang login
        $guru = Guru::where('Userid_user', Auth::user()->id_user)->first();

        // [PPLE-58] Ambil nilai tersimpan per siswa menggunakan foreign key
        $nilaiTersimpan = collect();
        if ($selectedKelas && $siswa->isNotEmpty()) {
            $siswaIds = $siswa->pluck('id_siswa');
            $query = Nilai::whereIn('Siswaid_siswa', $siswaIds);
            if ($selectedMapel) {
                $query = $query->where('Mata_Pelajaranid_mapel', $selectedMapel);
            }
            $nilaiTersimpan = $query->get()->keyBy('Siswaid_siswa');
        }



        return view('dashboard', compact(
            'kelasList',
            'mataPelajaran',
            'siswa',
            'selectedKelas',
            'selectedMapel',
            'kelasTerpilih',
            'guru',
            'nilaiTersimpan'
        ));
    }

    /**
     * Tampilkan halaman pilih mata pelajaran untuk guru.
     */
    public function selectMapel()
    {
        $guru = Guru::where('Userid_user', Auth::user()->id_user)->first();

        $semuaMataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        // ID mata pelajaran yang sudah dipilih guru ini
        $mataPelajaranDiampu = $guru
            ? $guru->mataPelajaran()->pluck('id_mapel')->toArray()
            : [];

        return view('dashboard-select-mapel', compact(
            'guru',
            'semuaMataPelajaran',
            'mataPelajaranDiampu'
        ));
    }

    /**
     * Simpan pilihan mata pelajaran guru.
     */
    public function storeMapel(Request $request)
    {
        $guru = Guru::where('Userid_user', Auth::user()->id_user)->first();

        if (!$guru) {
            return back()->withErrors(['guru' => 'Data guru tidak ditemukan.']);
        }

        $request->validate([
            'mata_pelajaran_ids'   => 'nullable|array',
            'mata_pelajaran_ids.*' => 'exists:mata_pelajaran,id_mapel',
        ]);

        // Sync pilihan (hapus lama, simpan baru)
        $guru->mataPelajaran()->sync($request->mata_pelajaran_ids ?? []);

        return redirect()->route('dashboard.select-mapel')
            ->with('success', 'Mata pelajaran berhasil disimpan!');
    }

    /**
     * Tampilkan halaman kelola siswa berdasarkan mata pelajaran.
     */
    public function manageStudents(Request $request)
    {
        $guru = Guru::where('Userid_user', Auth::user()->id_user)->first();

        // Mata pelajaran yang diampu guru ini
        $mataPelajaran = $guru
            ? $guru->mataPelajaran()->orderBy('nama_mapel')->get()
            : collect();

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $selectedMapel = $request->get('mapel_id');
        $selectedKelas = $request->get('kelas_id');

        $siswa = ($selectedKelas)
            ? Siswa::where('Kelasid_kelas', $selectedKelas)->orderBy('nama_siswa')->get()
            : collect();

        return view('dashboard-manage-students', compact(
            'guru',
            'mataPelajaran',
            'kelas',
            'siswa',
            'selectedMapel',
            'selectedKelas'
        ));
    }
}

