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
        $data = array_map('str_getcsv', file($path));

        foreach ($data as $index => $row) {
            if ($index === 0) continue;
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
     * Hapus Siswa
     */
    public function siswaImportPreview(Request $request)
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

    

    /**
     * Simpan Data ke Sistem setelah di-preview
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
                ]);
                $berhasil++;
            }
        }

        session()->forget('import_siswa_data');
        return redirect()->route('admin.siswa.index')->with('success', "$berhasil data siswa berhasil diunggah secara terpusat.");
    }

    /**
     * Fungsi dasar untuk menghapus siswa
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
     * Menampilkan halaman Data Lembaga dan Form Upload
     */
    public function lembagaIndex()
    
    {
        $lembaga = Lembaga::all();
        return view('admin.lembaga.index', compact('lembaga'));
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
     * Simpan Data Lembaga ke Sistem
     */
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
