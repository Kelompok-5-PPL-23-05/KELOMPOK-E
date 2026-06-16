<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Rapor;
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
     *   kelas_id              – id kelas terpilih
     *   mapel_id              – id mata pelajaran terpilih
     *   jenis_nilai           – UTS / UAS / Tugas
     *   nilai[n][siswa_id]    – primary key siswa
     *   nilai[n][angka]       – angka nilai (1-100)
     *   nilai[n][catatan]     – catatan opsional
     */
    public function store(Request $request)
    {
        // [PPLE-46] Validasi input agar nilai tidak kosong
        // [PPLE-44] Validasi range angka yang bisa dimasukkan dalam rapor (0–100)
        // [PPLE-50] Jika validasi gagal, Laravel otomatis memblokir penyimpanan dan redirect back dengan $errors
        $request->validate([
            'kelas_id'            => 'required|exists:kelas,id_kelas',
            'mapel_id'            => 'required|exists:mata_pelajaran,id_mapel',
            'jenis_nilai'         => 'required|in:UTS,UAS,Tugas',
            'nilai'               => 'required|array|min:1',
            'nilai.*.siswa_id'    => 'required|exists:siswa,id_siswa',
            // [PPLE-44] Range 0–100 (nilai 0 valid dalam sistem rapor)
            // [PPLE-46] required: field tidak boleh kosong
            'nilai.*.angka'       => 'required|integer|min:0|max:100',
            'nilai.*.catatan'     => 'nullable|string|max:500',
        ], [
            // [PPLE-48] Pesan error yang informatif
            'kelas_id.required'        => 'Kelas wajib dipilih.',
            'kelas_id.exists'          => 'Kelas tidak valid.',
            'mapel_id.required'        => 'Mata pelajaran wajib dipilih.',
            'mapel_id.exists'          => 'Mata pelajaran tidak valid.',
            'jenis_nilai.required'     => 'Jenis nilai wajib dipilih (UTS, UAS, atau Tugas).',
            'jenis_nilai.in'           => 'Jenis nilai hanya boleh UTS, UAS, atau Tugas.',
            'nilai.required'           => 'Data nilai siswa wajib diisi.',
            // [PPLE-46] Pesan error untuk field kosong
            'nilai.*.angka.required'   => 'Nilai siswa wajib diisi, tidak boleh dikosongkan.',
            // [PPLE-44] Pesan error untuk range tidak valid
            'nilai.*.angka.integer'    => 'Nilai harus berupa angka bulat (tidak boleh desimal).',
            'nilai.*.angka.min'        => 'Nilai minimal yang dapat dimasukkan adalah 0.',
            'nilai.*.angka.max'        => 'Nilai maksimal yang dapat dimasukkan adalah 100.',
        ]);

        $user  = Auth::user();
        $guru  = Guru::where('Userid_user', $user->id_user)->first();
        $mapel = MataPelajaran::find($request->mapel_id);

        foreach ($request->nilai as $entry) {
            $siswa = Siswa::find($entry['siswa_id']);

            // Simpan / update nilai ke tabel `nilai` (upsert per siswa+mapel+jenis)
            $existing = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
                ->where('Mata_Pelajaranid_mapel', $request->mapel_id)
                ->where('jenis_nilai', $request->jenis_nilai)
                ->first();

            if ($existing) {
                $existing->update([
                    'nilai_angka' => $entry['angka'],
                    'deskripsi'   => $entry['catatan'] ?? null,
                ]);
            } else {
                Nilai::create([
                    'nilai_angka'            => $entry['angka'],
                    'deskripsi'              => $entry['catatan'] ?? null,
                    'jenis_nilai'            => $request->jenis_nilai,
                    'Siswaid_siswa'          => $siswa->id_siswa,
                    'Guruid_guru'            => $guru ? $guru->id_guru : null,
                    'Mata_Pelajaranid_mapel' => $request->mapel_id,
                ]);
            }

            // Hitung dan update nilai akhir di rapor jika semua jenis nilai sudah ada
            $namaMapel = $mapel ? $mapel->nama_mapel : null;

            $nilaiUTS   = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
                               ->where('Mata_Pelajaranid_mapel', $request->mapel_id)
                               ->where('jenis_nilai', 'UTS')->latest()->first();
            $nilaiUAS   = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
                               ->where('Mata_Pelajaranid_mapel', $request->mapel_id)
                               ->where('jenis_nilai', 'UAS')->latest()->first();
            $nilaiTugas = Nilai::where('Siswaid_siswa', $siswa->id_siswa)
                               ->where('Mata_Pelajaranid_mapel', $request->mapel_id)
                               ->where('jenis_nilai', 'Tugas')->latest()->first();

            if ($nilaiUTS && $nilaiUAS && $nilaiTugas) {
                $nilaiAkhir = ($nilaiUTS->nilai_angka * 0.30)
                            + ($nilaiUAS->nilai_angka * 0.30)
                            + ($nilaiTugas->nilai_angka * 0.40);

                Rapor::updateOrCreate(
                    [
                        'Siswaid_siswa'  => $siswa->id_siswa,
                        'mata_pelajaran' => $namaMapel,
                    ],
                    ['nilai_akhir' => round($nilaiAkhir, 2)]
                );
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

    /**
     * [PPLE-58 & PPLE-59] Tampilkan form edit dengan data nilai yang sudah ada (pre-filled).
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