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

    /**
     * Menampilkan halaman Data Siswa
     */
    public function siswaIndex()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }

    /**
     * Validasi dan Simpan Data Master dari Form Upload
     */
    public function siswaImport(Request $request)
    {
        $request->validate([
            'file_master' => 'required|mimes:csv,txt|max:2048',
        ], [
            'file_master.required' => 'Pilih file terlebih dahulu.',
            'file_master.mimes' => 'Format file harus CSV.'
        ]);

        $file = $request->file('file_master');
        $path = $file->getRealPath();
        
        $lines = file($path);
        $delimiter = ',';
        if (count($lines) > 0 && strpos($lines[0], ';') !== false) {
            $delimiter = ';';
        }
        
        $data = [];
        foreach ($lines as $line) {
            $data[] = str_getcsv($line, $delimiter);
        }

        foreach ($data as $index => $row) {
            if ($index === 0) continue;
            if (!empty($row[0]) && !empty($row[1])) {
                Siswa::create([
                    'nama_siswa'    => trim($row[0]),
                    'Kelasid_kelas' => (int) trim($row[1]),
                    'nisn'          => trim($row[2] ?? null),
                    'alamat'        => trim($row[3] ?? null),
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
    
    /**
     * Update Data Siswa
     */
    public function siswaUpdate(Request $request, $id)
    {
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

        $siswa = Siswa::findOrFail($id);

        $siswa->update([
            'nama_siswa'     => $request->nama_siswa,
            'Kelasid_kelas'  => $request->Kelasid_kelas,
            'nisn'           => $request->nisn,
            'nis'            => $request->nis,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'agama'          => $request->agama,
            'anak_ke'        => $request->anak_ke,
            'telepon'        => $request->telepon,
            'alamat'         => $request->alamat,
            'nomor_gawai'    => $request->nomor_gawai,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'kelas_masuk'    => $request->kelas_masuk,
            'sebagai'        => $request->sebagai,
            'nama_ayah'      => $request->nama_ayah,
            'nama_ibu'       => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu'  => $request->pekerjaan_ibu,
            'nama_wali'      => $request->nama_wali,
            'pekerjaan_wali' => $request->pekerjaan_wali,
        ]);

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Validasi Format dan Tampilkan Preview Data Siswa
     */
    public function siswaImportPreview(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'file_master' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_master');
        $lines = file($file->getRealPath());
        $delimiter = ',';
        if (count($lines) > 0 && strpos($lines[0], ';') !== false) {
            $delimiter = ';';
        }
        
        $data = [];
        foreach ($lines as $line) {
            $data[] = str_getcsv($line, $delimiter);
        }
        $previewData = [];

        // Ambil data kelas dari database untuk pencocokan (case-insensitive)
        $kelasDB = \App\Models\Kelas::all();
        $kelasMap = [];
        $kelasIdMap = [];
        foreach ($kelasDB as $k) {
            $kelasMap[strtolower(trim($k->nama_kelas))] = $k->id_kelas;
            $kelasIdMap[$k->id_kelas] = $k->nama_kelas;
        }

        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Skip header

            $namaSiswa = trim($row[0] ?? '');
            
            // Kolom ke-2 adalah kelas (bisa ID atau Nama)
            $kelasInput = trim($row[1] ?? '');
            $kelasInputLower = strtolower($kelasInput);
            
            $idKelasDitemukan = null;
            $namaKelasDitemukan = '-';

            if (is_numeric($kelasInput) && isset($kelasIdMap[$kelasInput])) {
                $idKelasDitemukan = (int)$kelasInput;
                $namaKelasDitemukan = $kelasIdMap[$idKelasDitemukan];
            } else if (isset($kelasMap[$kelasInputLower])) {
                $idKelasDitemukan = $kelasMap[$kelasInputLower];
                $namaKelasDitemukan = $kelasInput;
            } else {
                // Fuzzy logic fallback: cari kata yang mirip atau sebagian teks (misal: user ketik "Kelas 1", padahal di DB "Paket B Kelas 1")
                foreach ($kelasMap as $namaDb => $idDb) {
                    if ($kelasInputLower !== '' && (strpos($namaDb, $kelasInputLower) !== false || strpos($kelasInputLower, $namaDb) !== false)) {
                        $idKelasDitemukan = $idDb;
                        $namaKelasDitemukan = $kelasIdMap[$idDb] . ' (Pencocokan: ' . $kelasInput . ')';
                        break;
                    }
                }
            }

            $nisn = trim($row[2] ?? '');
            $alamat = trim($row[3] ?? '');

            $previewData[] = [
                'nama_siswa' => $namaSiswa,
                'id_kelas'   => $idKelasDitemukan,
                'nama_kelas' => $namaKelasDitemukan,
                'nisn'       => $nisn,
                'alamat'     => $alamat,
                'status'     => (!empty($namaSiswa) && $idKelasDitemukan) ? 'Valid' : 'Data Kelas Tidak Ditemukan/Lengkap'
            ];
        }

        session(['import_siswa_data' => $previewData]);
        return view('admin.siswa.preview', compact('previewData'));
    }

    /**
     * Simpan Data Siswa ke Sistem setelah di-preview
     */
    public function siswaImportSave(Request $request)
    {
        $previewData = session('import_siswa_data');

        if (!$previewData) {
            return redirect()->route('admin.siswa.index')->with('error', 'Sesi upload kedaluwarsa.');
        }

        $berhasil = 0;
        foreach ($previewData as $row) {
            if ($row['status'] === 'Valid') {
                Siswa::create([
                    'nama_siswa'    => $row['nama_siswa'],
                    'Kelasid_kelas' => $row['id_kelas'],
                    'nisn'          => $row['nisn'] ?? null,
                    'alamat'        => $row['alamat'] ?? null,
                ]);
                $berhasil++;
            }
        }

        session()->forget('import_siswa_data');
        return redirect()->route('admin.siswa.index')->with('success', "$berhasil data siswa berhasil diunggah secara terpusat.");
    }

    /**
     * Fungsi untuk menghapus siswa
     */
    public function siswaDestroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Menampilkan halaman Data Kelas
     */
    public function kelasIndex()
    {
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

        Kelas::create(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Menghapus Data Kelas
     */
    public function kelasDestroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    /**
     * Menampilkan halaman Data Lembaga
     */
    public function lembaga()
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $lembaga = Lembaga::first();

        return view('admin.lembaga', compact('lembaga'));
    }

    /**
     * Menampilkan halaman Data Lembaga dan Form Upload
     */
    public function lembagaIndex()
    {
        $lembaga = Lembaga::all();
        return view('admin.lembaga.index', compact('lembaga'));
    }

    /**
     * Menampilkan halaman Edit Lembaga
     */
    public function lembagaEdit()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $lembaga = Lembaga::first();
        return view('admin.lembaga-edit', compact('lembaga'));
    }

    /**
     * Update Data Lembaga
     */
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
                'nama_lembaga', 'alamat', 'no_telepon', 'email', 'kepala_lembaga'
            ]));
        } else {
            Lembaga::create($request->only([
                'nama_lembaga', 'alamat', 'no_telepon', 'email', 'kepala_lembaga'
            ]));
        }

        return redirect()->route('admin.lembaga.edit')->with('success', 'Data lembaga berhasil diperbarui!');
    }

    /**
     * Validasi Format dan Tampilkan Preview Data Lembaga
     */
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

    /**
     * Simpan Data Lembaga ke Sistem setelah di-preview
     */
    public function lembagaImportSave(Request $request)
    {
        $previewData = session('import_lembaga_data');

        if (!$previewData) {
            return redirect()->route('admin.lembaga.index')->with('error', 'Sesi upload kedaluwarsa.');
        }

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

    /**
     * Menampilkan halaman Data Mata Pelajaran
     */
    public function mapelIndex()
    {
        $mapel = MataPelajaran::all();
        return view('admin.mapel.index', compact('mapel'));
    }

    /**
     * Menyimpan Data Mata Pelajaran Baru
     */
    public function mapelStore(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel',
        ], [
            'nama_mapel.required' => 'Nama mapel wajib diisi.',
            'nama_mapel.unique' => 'Nama mapel ini sudah ada.'
        ]);

        MataPelajaran::create(['nama_mapel' => $request->nama_mapel]);
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    /**
     * Update Data Mata Pelajaran
     */
    public function mapelUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel,' . $id . ',id_mapel',
        ], [
            'nama_mapel.required' => 'Nama mapel wajib diisi.',
            'nama_mapel.unique' => 'Nama mapel ini sudah ada.'
        ]);

        $mapel = MataPelajaran::findOrFail($id);
        $mapel->update(['nama_mapel' => $request->nama_mapel]);

        return back()->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus Data Mata Pelajaran
     */
    public function mapelDestroy($id)
    {
        MataPelajaran::findOrFail($id)->delete();
        return back()->with('success', 'Mata Pelajaran berhasil dihapus.');
    }

    /**
     * Menghapus Semua Data Mapel
     */
    public function mapelDestroyAll()
    {
        MataPelajaran::query()->delete();
        return back()->with('success', 'Semua Data Mata Pelajaran berhasil dihapus.');
    }

    /**
     * Mengimpor Data Mapel dari CSV (Langsung)
     */
    public function mapelImport(Request $request)
    {
        $request->validate([
            'file_master' => 'required|mimes:csv,txt|max:2048',
        ], [
            'file_master.required' => 'Pilih file terlebih dahulu.',
            'file_master.mimes' => 'Format file harus CSV.'
        ]);

        $file = $request->file('file_master');
        $lines = file($file->getRealPath());
        $delimiter = ',';
        if (count($lines) > 0 && strpos($lines[0], ';') !== false) {
            $delimiter = ';';
        }
        
        $data = [];
        foreach ($lines as $line) {
            $data[] = str_getcsv($line, $delimiter);
        }

        $berhasil = 0;
        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Skip header
            $namaMapel = trim($row[0] ?? '');
            
            if (!empty($namaMapel)) {
                $exists = MataPelajaran::where('nama_mapel', $namaMapel)->first();
                if (!$exists) {
                    MataPelajaran::create(['nama_mapel' => $namaMapel]);
                    $berhasil++;
                }
            }
        }

        return back()->with('success', "$berhasil data mata pelajaran berhasil diimpor.");
    }

    /**
     * Validasi Format dan Tampilkan Preview Data Mapel
     */
    public function mapelImportPreview(Request $request)
    {
        $request->validate([
            'file_master' => 'required|mimes:csv,txt|max:2048',
        ], [
            'file_master.required' => 'Pilih file terlebih dahulu.',
            'file_master.mimes' => 'Format file yang diunggah harus CSV.'
        ]);

        $file = $request->file('file_master');
        $lines = file($file->getRealPath());
        $delimiter = ',';
        if (count($lines) > 0 && strpos($lines[0], ';') !== false) {
            $delimiter = ';';
        }
        
        $data = [];
        foreach ($lines as $line) {
            $data[] = str_getcsv($line, $delimiter);
        }
        
        $previewData = [];

        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Skip header
            $namaMapel = trim($row[0] ?? '');
            
            $previewData[] = [
                'nama_mapel' => $namaMapel,
                'status'     => !empty($namaMapel) ? 'Valid' : 'Nama Wajib Diisi'
            ];
        }

        session(['import_mapel_data' => $previewData]);
        return view('admin.mapel.preview', compact('previewData'));
    }

    /**
     * Simpan Data Mapel ke Sistem setelah di-preview
     */
    public function mapelImportSave(Request $request)
    {
        $previewData = session('import_mapel_data');

        if (!$previewData) {
            return redirect()->route('admin.mapel.index')->with('error', 'Sesi upload kedaluwarsa.');
        }

        $berhasil = 0;
        foreach ($previewData as $row) {
            if ($row['status'] === 'Valid') {
                MataPelajaran::firstOrCreate([
                    'nama_mapel' => $row['nama_mapel']
                ]);
                $berhasil++;
            }
        }

        session()->forget('import_mapel_data');
        return redirect()->route('admin.mapel.index')->with('success', "$berhasil data mata pelajaran berhasil diunggah.");
    }
}