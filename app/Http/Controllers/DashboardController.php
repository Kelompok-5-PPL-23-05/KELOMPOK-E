<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard/homepage
     */
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();

        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');

        $siswa = [];
        if ($selectedKelas) {
            $siswa = Siswa::where('Kelasid_kelas', $selectedKelas)->get();
        }

        return view('dashboard', compact('kelas', 'mataPelajaran', 'siswa', 'selectedKelas', 'selectedMapel'));
    }
}
