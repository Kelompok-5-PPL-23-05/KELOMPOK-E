<?php

namespace App\Services;

use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Rapor;

class NilaiAverager
{
    private const WEIGHTS = [
        'UTS' => 0.30,
        'UAS' => 0.30,
        'Tugas' => 0.40,
    ];

    /**
     * Hitung nilai akhir berbobot untuk satu siswa dan satu mata pelajaran.
     */
    public function computeForStudentMapel(int $siswaId, int $mapelId): ?float
    {
        $nilaiByJenis = Nilai::where('Siswaid_siswa', $siswaId)
            ->where('Mata_Pelajaranid_mapel', $mapelId)
            ->whereIn('jenis_nilai', array_keys(self::WEIGHTS))
            ->get()
            ->keyBy('jenis_nilai');

        foreach (array_keys(self::WEIGHTS) as $jenis) {
            if (!$nilaiByJenis->has($jenis)) {
                return null;
            }
        }

        $finalScore = 0;
        foreach (self::WEIGHTS as $jenis => $weight) {
            $finalScore += $nilaiByJenis[$jenis]->nilai_angka * $weight;
        }

        $finalScore = round($finalScore, 2);

        $mapel = MataPelajaran::find($mapelId);
        if (!$mapel) {
            return null;
        }

        Rapor::updateOrCreate(
            [
                'Siswaid_siswa' => $siswaId,
                'mata_pelajaran' => $mapel->nama_mapel,
            ],
            [
                'nilai_rata' => $finalScore,
                'nilai_akhir' => (int) round($finalScore),
            ]
        );

        return $finalScore;
    }

    public function computeForStudent(int $siswaId): void
    {
        $mapelIds = Nilai::where('Siswaid_siswa', $siswaId)
            ->pluck('Mata_Pelajaranid_mapel')
            ->unique();

        foreach ($mapelIds as $mapelId) {
            $this->computeForStudentMapel($siswaId, $mapelId);
        }
    }

    public function computeAll(): void
    {
        $pairs = Nilai::select('Siswaid_siswa', 'Mata_Pelajaranid_mapel')
            ->distinct()
            ->get();

        foreach ($pairs as $pair) {
            $this->computeForStudentMapel($pair->Siswaid_siswa, $pair->Mata_Pelajaranid_mapel);
        }
    }
}
