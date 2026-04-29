<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $data = Nilai::all();
        return view('nilai.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa.*' => 'required',
            'kelas' => 'required',
            'mata_pelajaran' => 'required',
            'nilai.*' => 'required|integer|min:1|max:100',
        ]);

        foreach ($request->nama_siswa as $i => $nama) {
            Nilai::create([
                'nama_siswa' => $nama,
                'kelas' => $request->kelas,
                'mata_pelajaran' => $request->mata_pelajaran,
                'nilai' => $request->nilai[$i],
                'catatan' => $request->catatan[$i] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan');
    }

    public function create(){}
    public function show(Nilai $nilai){}
    public function edit(Nilai $nilai){}
    public function update(Request $request, Nilai $nilai){}
    public function destroy(Nilai $nilai){}
}