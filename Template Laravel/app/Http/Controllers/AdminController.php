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

    public function siswaStore(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'Kelasid_kelas' => 'required|exists:kelas,id_kelas'
        ]);

        Siswa::create($request->all());
        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function siswaImportPreview(Request $request)
    {
        $request->validate([
            'file_master' => 'required|mimes:csv,txt|max:2048',
        ], [
            'file_master.mimes' => 'Format file wajib CSV.'
        ]);

        $file = $request->file('file_master');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        $semuaKelas = Kelas::pluck('id_kelas', 'nama_kelas')->toArray();

        $previewData = [];

        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Abaikan baris header CSV

            $nama_siswa = trim($row[0] ?? '');
            $nama_kelas = trim($row[1] ?? '');

            if (empty($nama_siswa)) continue;

            // Cari id_kelas berdasarkan nama kelas yang diketik di CSV
            // Jika tidak ada, beri nilai null
            $id_kelas = $semuaKelas[$nama_kelas] ?? null;

            $previewData[] = [
                'nama_siswa' => $nama_siswa,
                'nama_kelas' => $nama_kelas,
                'id_kelas'   => $id_kelas,
                'status'     => $id_kelas ? 'Valid' : 'Kelas Tidak Ditemukan'
            ];
        }

        
        session(['import_siswa_data' => $previewData]);
        
        return view('admin.siswa.preview', compact('previewData'));
    }

    public function siswaImportSave(Request $request)
    {
        $previewData = session('import_siswa_data');

        if (!$previewData) {
            return redirect()->route('admin.siswa.index')->with('error', 'Sesi upload kedaluwarsa.');
        }

        $berhasil = 0;
        foreach ($previewData as $row) {
            // Hanya simpan data yang kelasnya valid (ditemukan di DB)
            if ($row['status'] === 'Valid') {
                Siswa::create([
                    'nama_siswa'    => $row['nama_siswa'],
                    'Kelasid_kelas' => $row['id_kelas'],
                ]);
                $berhasil++;
            }
        }

        // Hapus session setelah disimpan
        session()->forget('import_siswa_data');

        return redirect()->route('admin.siswa.index')->with('success', "$berhasil data siswa berhasil diunggah secara terpusat.");
    }

    public function siswaDestroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function kelasIndex()
    {
        // Mengambil semua kelas beserta jumlah siswa di masing-masing kelas
        $kelas = Kelas::withCount('siswa')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Menyimpan Data Kelas Baru
     */
    public function kelasStore(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.unique' => 'Nama kelas ini sudah ada.'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Menghapus Data Kelas
     */
    public function kelasDestroy($id)
    {
        // Karena di migration Anda menggunakan onDelete('cascade'),
        // jika kelas dihapus, siswa di dalamnya juga akan terhapus.
        Kelas::findOrFail($id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    
    public function lembagaIndex()
    {
        // Mengambil semua data lembaga untuk ditampilkan di tabel
        $lembaga = Lembaga::all();
        
        return view('admin.lembaga.index', compact('lembaga'));
    }

    public function lembagaIndex()
    {
        $lembaga = Lembaga::all();
        
        return view('admin.lembaga.index', compact('lembaga'));
    }

    public function lembagaImportPreview(Request $request)
    {
       $request->validate([
            'file_master' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_master');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        $previewData = [];
        foreach ($data as $index => $row) {
            if ($index === 0) continue;
            $previewData[] = [
                'nama_lembaga' => trim($row[0] ?? ''),
                'alamat'       => trim($row[1] ?? ''),
                'kontak'       => trim($row[2] ?? ''),
                'status'       => !empty($row[0]) ? 'Valid' : 'Nama Wajib Diisi'
            ];
        }

        session(['import_lembaga_data' => $previewData]);
        return view('admin.lembaga.preview', compact('previewData'));
    }

    public function lembagaImportSave(Request $request)
    {
        $previewData = session('import_lembaga_data');

        foreach ($previewData as $row) {
            if ($row['status'] === 'Valid') {
                Lembaga::create([
                    'nama_lembaga' => $row['nama_lembaga'],
                    'alamat'       => $row['alamat'],
                    'kontak'       => $row['kontak'],
                ]);
            }
        }

        session()->forget('import_lembaga_data');
        return redirect()->route('admin.lembaga.index')->with('success', 'Data lembaga berhasil disimpan secara terpusat.');
    }
}
