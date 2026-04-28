<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function getByKelas($id_kelas)
    {
        $siswa = Siswa::where('Kelasid_kelas', $id_kelas)->get();

        if ($siswa->isEmpty()) {
            return response()->json(['message' => 'Tidak ada siswa di kelas ini'], 404);
        }

        return response()->json($siswa);
    }

    public function update(Request $request, $id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->save();

        return response()->json(['message' => 'Data siswa berhasil diupdate', 'data' => $siswa]);
    }

    public function destroy($id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->delete();

        return response()->json(['message' => 'Siswa berhasil dihapus']);
    }
}