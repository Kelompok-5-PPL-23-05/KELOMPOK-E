<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    /**
     * PPLE-66: Tampilkan form input kehadiran.
     */
    public function index(Request $request)
    {
        $kelasList    = Kelas::all();
        $selectedKelas = $request->get('kelas_id');
        $siswa        = [];

        if ($selectedKelas) {
            $siswa = Siswa::where('Kelasid_kelas', $selectedKelas)->get();
        }

        return view('absensi.index', compact('kelasList', 'selectedKelas', 'siswa'));
    }

    /**
     * PPLE-67 + PPLE-68: Validasi dan simpan data absensi ke database.
     */
    public function store(Request $request)
    {
        // ── PPLE-67: Validasi input ───────────────────────────────────
        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id_kelas',
            'absensi'           => 'required|array|min:1',
            'absensi.*.siswa_id'=> 'required|exists:siswa,id_siswa',
            'absensi.*.hadir'   => 'required|integer|min:0',
            'absensi.*.sakit'   => 'required|integer|min:0',
            'absensi.*.izin'    => 'required|integer|min:0',
            'absensi.*.alfa'    => 'required|integer|min:0',
        ], [
            'kelas_id.required'           => 'Kelas wajib dipilih.',
            'absensi.*.hadir.required'    => 'Jumlah hari hadir wajib diisi.',
            'absensi.*.hadir.min'         => 'Jumlah hari hadir tidak boleh negatif.',
            'absensi.*.sakit.required'    => 'Jumlah hari sakit wajib diisi.',
            'absensi.*.sakit.min'         => 'Jumlah hari sakit tidak boleh negatif.',
            'absensi.*.izin.required'     => 'Jumlah hari izin wajib diisi.',
            'absensi.*.izin.min'          => 'Jumlah hari izin tidak boleh negatif.',
            'absensi.*.alfa.required'     => 'Jumlah hari alfa wajib diisi.',
            'absensi.*.alfa.min'          => 'Jumlah hari alfa tidak boleh negatif.',
        ]);

        // ── PPLE-68: Simpan ke database ──────────────────────────────
        foreach ($request->absensi as $row) {
            // updateOrCreate agar tidak duplikat jika guru menginput ulang
            Absensi::updateOrCreate(
                ['Siswaid_siswa' => $row['siswa_id']],
                [
                    'hadir' => $row['hadir'],
                    'sakit' => $row['sakit'],
                    'izin'  => $row['izin'],
                    'alfa'  => $row['alfa'],
                ]
            );
        }

        return redirect()
            ->route('absensi.index', ['kelas_id' => $request->kelas_id])
            ->with('success', 'Data absensi berhasil disimpan!');
    }

    /**
     * PPLE-69: Tampilkan rekap jumlah kehadiran per siswa.
     */
    public function rekap(Request $request)
    {
        $kelasList     = Kelas::all();
        $selectedKelas = $request->get('kelas_id');
        $rekap         = [];

        if ($selectedKelas) {
            $siswaList = Siswa::where('Kelasid_kelas', $selectedKelas)->get();

            foreach ($siswaList as $siswa) {
                $absensi = Absensi::where('Siswaid_siswa', $siswa->id_siswa)->first();

                $rekap[] = [
                    'nama_siswa' => $siswa->nama_siswa,
                    'hadir'      => $absensi ? $absensi->hadir : 0,
                    'sakit'      => $absensi ? $absensi->sakit : 0,
                    'izin'       => $absensi ? $absensi->izin  : 0,
                    'alfa'       => $absensi ? $absensi->alfa  : 0,
                    'total'      => $absensi ? $absensi->total_hari : 0,
                ];
            }
        }

        return view('absensi.rekap', compact('kelasList', 'selectedKelas', 'rekap'));
    }
}
