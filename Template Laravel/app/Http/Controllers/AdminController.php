<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Lembaga;

class AdminController extends Controller
{
    /**
     * Halaman Dashboard Admin
     */
    public function dashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $stats = [
            'total_siswa'  => Siswa::count(),
            'total_guru'   => Guru::count(),
            'total_kelas'  => Kelas::count(),
            'total_mapel'  => MataPelajaran::count(),
        ];

        $kelas    = Kelas::withCount('siswa')->get();
        $guruList = Guru::with('user')->get();

        return view('admin.dashboard', compact('stats', 'kelas', 'guruList'));
    }

    /**
     * Halaman Daftar Siswa
     */
    public function siswa()
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $siswaList = Siswa::with('kelas')->get();
        $kelasList = Kelas::all();

        return view('admin.siswa.siswa', compact('siswaList', 'kelasList'));
    }

    /**
     * Simpan Siswa Baru
     */
    public function storeSiswa(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'nama_siswa'     => 'required|string|max:255',
            'Kelasid_kelas'  => 'required|exists:kelas,id_kelas',
            'nisn'           => 'nullable|string|max:20',
            'nis'            => 'nullable|string|max:20',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'agama'          => 'nullable|string|max:50',
            'anak_ke'        => 'nullable|integer|min:1',
            'telepon'        => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
            'nomor_gawai'    => 'nullable|string|max:20',
            'tanggal_masuk'  => 'nullable|date',
            'kelas_masuk'    => 'nullable|string|max:10',
            'sebagai'        => 'nullable|string|max:50',
            'nama_ayah'      => 'nullable|string|max:100',
            'nama_ibu'       => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu'  => 'nullable|string|max:100',
            'nama_wali'      => 'nullable|string|max:100',
            'pekerjaan_wali' => 'nullable|string|max:100',
        ], [
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'Kelasid_kelas.required' => 'Kelas wajib dipilih.',
            'Kelasid_kelas.exists'   => 'Kelas tidak valid.',
        ]);

        Siswa::create($request->only([
            'nama_siswa', 'Kelasid_kelas',
            'nisn', 'nis',
            'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama',
            'anak_ke', 'telepon', 'alamat', 'nomor_gawai',
            'tanggal_masuk', 'kelas_masuk', 'sebagai',
            'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu',
            'nama_wali', 'pekerjaan_wali',
        ]));

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan!');
    }

    /**
     * Hapus Siswa
     */
    public function destroySiswa($id)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        Siswa::findOrFail($id)->delete();

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Halaman Lembaga
     */
    public function lembaga()
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $lembaga = Lembaga::first();

        return view('admin.lembaga', compact('lembaga'));
    }

    public function lembagaEdit()
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $lembaga = Lembaga::first();

        return view('admin.lembaga-edit', compact('lembaga'));
    }

    public function updateLembaga(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'nama_lembaga'   => 'required|string|max:255',
            'alamat'         => 'required|string',
            'no_telepon'     => 'required|string|max:20',
            'email'          => 'required|email|max:255',
            'kepala_lembaga' => 'required|string|max:255',
        ], [
            'nama_lembaga.required'   => 'Nama lembaga wajib diisi.',
            'alamat.required'         => 'Alamat wajib diisi.',
            'no_telepon.required'     => 'No. telepon wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email tidak valid.',
            'kepala_lembaga.required' => 'Nama kepala lembaga wajib diisi.',
        ]);

        $lembaga = Lembaga::first();

        if ($lembaga) {
            $lembaga->update($request->only([
                'nama_lembaga',
                'alamat',
                'no_telepon',
                'email',
                'kepala_lembaga'
            ]));
        } else {
            Lembaga::create($request->only([
                'nama_lembaga',
                'alamat',
                'no_telepon',
                'email',
                'kepala_lembaga'
            ]));
        }

        return redirect()->route('admin.lembaga')->with('success', 'Data lembaga berhasil diperbarui!');
    }
}