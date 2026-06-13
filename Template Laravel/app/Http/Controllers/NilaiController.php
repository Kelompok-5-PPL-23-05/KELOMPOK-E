<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Rapor;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $data = Nilai::all();
        return view('nilai.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'            => 'required|exists:kelas,id_kelas',
            'mapel_id'            => 'nullable|exists:mata_pelajaran,id_mapel',
            'jenis_nilai'         => 'required|in:UTS,UAS,Tugas',
            'nilai'               => 'required|array|min:1',
            'nilai.*.siswa_id'    => 'required|exists:siswa,id_siswa',
            'nilai.*.angka'       => 'required|integer|min:1|max:100',
            'nilai.*.catatan'     => 'nullable|string|max:500',
        ], [
            'kelas_id.required'        => 'Kelas wajib dipilih.',
            'kelas_id.exists'          => 'Kelas tidak valid.',
            'jenis_nilai.required'     => 'Jenis nilai wajib dipilih.',
            'nilai.*.angka.required'   => 'Semua nilai siswa wajib diisi.',
            'nilai.*.angka.min'        => 'Nilai minimal adalah 1.',
            'nilai.*.angka.max'        => 'Nilai maksimal adalah 100.',
        ]);

        $kelas = Kelas::find($request->kelas_id);
        $mapel = $request->mapel_id ? MataPelajaran::find($request->mapel_id) : null;

        foreach ($request->nilai as $entry) {
            $siswa = Siswa::find($entry['siswa_id']);

            Nilai::create([
                'nama_siswa'     => $siswa->nama_siswa,
                'kelas'          => $kelas->nama_kelas,
                'mata_pelajaran' => $mapel ? $mapel->nama_mapel : '-',
                'nilai'          => $entry['angka'],
                'catatan'        => $entry['catatan'] ?? null,
                'jenis_nilai'    => $request->jenis_nilai,
            ]);

            if ($mapel) {
                $namaMapel  = $mapel->nama_mapel;
                $namaSiswa  = $siswa->nama_siswa;

                $nilaiUTS   = Nilai::where('nama_siswa', $namaSiswa)
                                   ->where('mata_pelajaran', $namaMapel)
                                   ->where('jenis_nilai', 'UTS')->latest()->first();
                $nilaiUAS   = Nilai::where('nama_siswa', $namaSiswa)
                                   ->where('mata_pelajaran', $namaMapel)
                                   ->where('jenis_nilai', 'UAS')->latest()->first();
                $nilaiTugas = Nilai::where('nama_siswa', $namaSiswa)
                                   ->where('mata_pelajaran', $namaMapel)
                                   ->where('jenis_nilai', 'Tugas')->latest()->first();

                if ($nilaiUTS && $nilaiUAS && $nilaiTugas) {
                    $nilaiAkhir = ($nilaiUTS->nilai * 0.30)
                                + ($nilaiUAS->nilai * 0.30)
                                + ($nilaiTugas->nilai * 0.40);

                    Rapor::updateOrCreate(
                        [
                            'Siswaid_siswa'  => $siswa->id_siswa,
                            'mata_pelajaran' => $namaMapel,
                        ],
                        ['nilai_akhir' => round($nilaiAkhir, 2)]
                    );
                }
            }
        }

        return redirect()
            ->route('dashboard', [
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $request->mapel_id,
            ])
            ->with('success', 'Nilai berhasil disimpan!');
    }

    public function nilaiAkhir(Request $request)
    {
        $kelasList     = Kelas::orderBy('nama_kelas')->get();
        $selectedKelas = $request->get('kelas_id');

        $rapor = collect();
        if ($selectedKelas) {
            $siswaIds = Siswa::where('Kelasid_kelas', $selectedKelas)
                             ->pluck('id_siswa');

            $rapor = Rapor::whereIn('Siswaid_siswa', $siswaIds)
                          ->with('siswa')
                          ->get()
                          ->groupBy('Siswaid_siswa');
        }

        return view('nilai.akhir', compact('kelasList', 'selectedKelas', 'rapor'));
    }

    public function create(){}
    public function show(Nilai $nilai){}
    public function edit(Nilai $nilai){}
    public function update(Request $request, Nilai $nilai){}
    public function destroy(Nilai $nilai){}
}