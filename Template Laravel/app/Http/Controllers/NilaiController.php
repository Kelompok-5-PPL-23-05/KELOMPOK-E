<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $data = Nilai::all();
        return view('nilai.index', compact('data'));
    }

    /**
     * Simpan nilai seluruh siswa dalam satu kelas.
     * Form dikirim dari dashboard guru (/dashboard?kelas_id=x&mapel_id=y).
     *
     * Input:
     *   kelas_id          – id kelas terpilih
     *   mapel_id          – id mata pelajaran terpilih
     *   nilai[n][siswa_id]  – primary key siswa
     *   nilai[n][angka]     – angka nilai (1-100)
     *   nilai[n][catatan]   – catatan opsional
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'            => 'required|exists:kelas,id_kelas',
            'mapel_id'            => 'nullable|exists:mata_pelajaran,id_mapel',
            'nilai'               => 'required|array|min:1',
            'nilai.*.siswa_id'    => 'required|exists:siswa,id_siswa',
            'nilai.*.angka'       => 'required|integer|min:1|max:100',
            'nilai.*.catatan'     => 'nullable|string|max:500',
        ], [
            'kelas_id.required'        => 'Kelas wajib dipilih.',
            'kelas_id.exists'          => 'Kelas tidak valid.',
            'nilai.*.angka.required'   => 'Semua nilai siswa wajib diisi.',
            'nilai.*.angka.min'        => 'Nilai minimal adalah 1.',
            'nilai.*.angka.max'        => 'Nilai maksimal adalah 100.',
        ]);

        // Resolve nama kelas & mata pelajaran untuk disimpan sebagai string
        $kelas  = Kelas::find($request->kelas_id);
        $mapel  = $request->mapel_id
            ? MataPelajaran::find($request->mapel_id)
            : null;

        foreach ($request->nilai as $entry) {
            $siswa = Siswa::find($entry['siswa_id']);

            Nilai::create([
                'nama_siswa'    => $siswa->nama_siswa,
                'kelas'         => $kelas->nama_kelas,
                'mata_pelajaran'=> $mapel ? $mapel->nama_mapel : '-',
                'nilai'         => $entry['angka'],
                'catatan'       => $entry['catatan'] ?? null,
            ]);
        }

        // Redirect kembali ke dashboard dengan filter kelas & mapel yang sama
        return redirect()
            ->route('dashboard', [
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $request->mapel_id,
            ])
            ->with('success', 'Nilai berhasil disimpan!');
    }

    public function create(){}
    public function show(Nilai $nilai){}
    public function edit(Nilai $nilai){}
    public function update(Request $request, Nilai $nilai){}
    public function destroy(Nilai $nilai){}
}