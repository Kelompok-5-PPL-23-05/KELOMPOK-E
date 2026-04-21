<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\User;
use App\Models\Absensi;

class AdminController extends Controller
{
    /**
     * Middleware: hanya admin yang boleh akses
     */
    private function checkAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
    }

    /* ══════════════════════════════════════════════
     |  DASHBOARD UTAMA
     ══════════════════════════════════════════════ */
    public function dashboard()
    {
        $this->checkAdmin();

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

    /* ══════════════════════════════════════════════
     |  MANAJEMEN SISWA
     ══════════════════════════════════════════════ */
    public function siswaIndex()
    {
        $this->checkAdmin();
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $kelas = Kelas::all();
        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }

    public function siswaStore(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_siswa'   => 'required|string|max:255',
            'Kelasid_kelas' => 'required|exists:kelas,id_kelas',
        ], [
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'Kelasid_kelas.required' => 'Kelas wajib dipilih.',
            'Kelasid_kelas.exists'   => 'Kelas tidak valid.',
        ]);

        Siswa::create([
            'nama_siswa'    => $request->nama_siswa,
            'Kelasid_kelas' => $request->Kelasid_kelas,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function siswaUpdate(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_siswa'    => 'required|string|max:255',
            'Kelasid_kelas' => 'required|exists:kelas,id_kelas',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nama_siswa'    => $request->nama_siswa,
            'Kelasid_kelas' => $request->Kelasid_kelas,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function siswaDestroy($id)
    {
        $this->checkAdmin();
        Siswa::findOrFail($id)->delete();
        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus!');
    }

    /* ══════════════════════════════════════════════
     |  MANAJEMEN KELAS
     ══════════════════════════════════════════════ */
    public function kelasIndex()
    {
        $this->checkAdmin();
        $kelas = Kelas::withCount('siswa')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function kelasStore(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.unique'   => 'Nama kelas sudah ada.',
        ]);

        Kelas::create(['nama_kelas' => $request->nama_kelas]);
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function kelasUpdate(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id . ',id_kelas',
        ]);

        Kelas::findOrFail($id)->update(['nama_kelas' => $request->nama_kelas]);
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function kelasDestroy($id)
    {
        $this->checkAdmin();
        Kelas::findOrFail($id)->delete();
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus!');
    }

    /* ══════════════════════════════════════════════
     |  MANAJEMEN MATA PELAJARAN
     ══════════════════════════════════════════════ */
    public function mapelIndex()
    {
        $this->checkAdmin();
        $mapel = MataPelajaran::all();
        return view('admin.mapel.index', compact('mapel'));
    }

    public function mapelStore(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel',
        ], [
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
            'nama_mapel.unique'   => 'Mata pelajaran sudah ada.',
        ]);

        MataPelajaran::create(['nama_mapel' => $request->nama_mapel]);
        return redirect()->route('admin.mapel')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function mapelUpdate(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel,' . $id . ',id_mapel',
        ]);

        MataPelajaran::findOrFail($id)->update(['nama_mapel' => $request->nama_mapel]);
        return redirect()->route('admin.mapel')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function mapelDestroy($id)
    {
        $this->checkAdmin();
        MataPelajaran::findOrFail($id)->delete();
        return redirect()->route('admin.mapel')->with('success', 'Mata pelajaran berhasil dihapus!');
    }

    /* ══════════════════════════════════════════════
     |  MANAJEMEN GURU
     ══════════════════════════════════════════════ */
    public function guruIndex()
    {
        $this->checkAdmin();
        $guru = Guru::with('user')->get();
        return view('admin.guru.index', compact('guru'));
    }

    public function guruStore(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username',
            'password'  => 'required|string|min:6',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
        ]);

        // Buat user terlebih dahulu
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => 'guru',
        ]);

        // Buat data guru
        Guru::create([
            'nama_guru'   => $request->nama_guru,
            'Userid_user' => $user->id_user,
        ]);

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function guruDestroy($id)
    {
        $this->checkAdmin();
        $guru = Guru::with('user')->findOrFail($id);
        // Hapus user terkait (cascade akan menghapus guru juga)
        if ($guru->user) {
            $guru->user->delete();
        } else {
            $guru->delete();
        }
        return redirect()->route('admin.guru')->with('success', 'Guru berhasil dihapus!');
    }
}
