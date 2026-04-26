<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;

class AdminController extends Controller
{
    /**
     * Halaman Dashboard Admin
     * Menampilkan ringkasan data: total siswa, guru, kelas, mapel
     */
    public function dashboard()
    {
        // Pastikan hanya admin yang bisa akses
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

    public function siswaIndex()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }
    
    public function siswaImport(Request $request)
    {
        // 1. Validasi Data Sebelum Simpan (Subtask 4)
        // Memastikan file yang diupload ada, berformat CSV, dan ukurannya tidak lebih dari 2MB
        $request->validate([
            'file_master' => 'required|mimes:csv,txt|max:2048',
        ], [
            'file_master.required' => 'Pilih file terlebih dahulu.',
            'file_master.mimes' => 'Format file harus CSV.'
        ]);

        // 2. Simpan Data ke Database (Subtask 3)
        $file = $request->file('file_master');
        $path = $file->getRealPath();
        
        // Membaca isi file CSV
        $data = array_map('str_getcsv', file($path));

        // Looping untuk menyimpan setiap baris data secara otomatis
        foreach ($data as $index => $row) {
            // Abaikan baris pertama jika itu adalah header kolom (Nama, ID Kelas)
            if ($index === 0) continue; 

            // Validasi data di dalam sel CSV (pastikan tidak kosong)
            if (!empty($row[0]) && !empty($row[1])) {
                Siswa::create([
                    'nama_siswa'    => trim($row[0]),
                    'Kelasid_kelas' => (int) trim($row[1]),
                ]);
            }
        }

        return back()->with('success', 'Data master siswa berhasil diunggah dan disimpan ke database secara otomatis.');
    }

    /**
     * Fungsi dasar untuk tombol "Tambah Siswa" manual
     */
    public function siswaStore(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'Kelasid_kelas' => 'required|exists:kelas,id_kelas'
        ]);

        Siswa::create($request->all());
        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function lembagaIndex()
    {
        // Mengambil semua data lembaga untuk ditampilkan di tabel
        $lembaga = Lembaga::all();
        
        return view('admin.lembaga.index', compact('lembaga'));
    }
}
