<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Ambil guru yang sedang login
        $guru = Guru::where('Userid_user', Auth::user()->id_user)->first();

        foreach ($request->nilai as $entry) {
            Nilai::create([
                'nilai_angka'           => $entry['angka'],
                'deskripsi'             => $entry['catatan'] ?? null,
                'Siswaid_siswa'         => $entry['siswa_id'],
                'Guruid_guru'           => $guru ? $guru->id_guru : null,
                'Mata_Pelajaranid_mapel'=> $request->mapel_id,
            ]);
        }

        return redirect()
            ->route('dashboard', [
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $request->mapel_id,
            ])
            ->with('success', 'Nilai berhasil disimpan!');
    }

    public function create(){}
    public function show(Nilai $nilai){}

    /**
     * [PPLE-58] Tampilkan form edit dengan data nilai yang sudah ada (pre-filled).
     */
    public function edit(Nilai $nilai)
    {
        return view('nilai.edit', compact('nilai'));
    }

    /**
     * [PPLE-60 & PPLE-61] Validasi input lalu update data nilai ke database.
     */
    public function update(Request $request, Nilai $nilai)
    {
        // PPLE-60: Validasi input nilai
        $validated = $request->validate([
            'nilai_angka' => 'required|numeric|integer|min:1|max:100',
            'deskripsi'   => 'nullable|string|max:500',
        ], [
            'nilai_angka.required' => 'Nilai wajib diisi.',
            'nilai_angka.numeric'  => 'Nilai harus berupa angka.',
            'nilai_angka.integer'  => 'Nilai harus berupa bilangan bulat.',
            'nilai_angka.min'      => 'Nilai minimal adalah 1.',
            'nilai_angka.max'      => 'Nilai maksimal adalah 100.',
        ]);

        // PPLE-61: Update data ke database
        $nilai->update([
            'nilai_angka' => $validated['nilai_angka'],
            'deskripsi'   => $validated['deskripsi'] ?? null,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Nilai siswa berhasil diperbarui!');
    }

    public function destroy(Nilai $nilai){}
}