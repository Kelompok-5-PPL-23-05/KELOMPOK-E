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

    /**
     * Tampilkan rekap nilai akhir per kelas (dari tabel rapor)
     */
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