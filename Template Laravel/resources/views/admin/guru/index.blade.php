@extends('admin.layout')

@section('title', 'Data Guru')

@section('content')
<h1 class="page-title">Data Guru</h1>
<p class="page-subtitle">Kelola akun dan data guru PKBM</p>

<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
            Daftar Guru ({{ $guru->count() }} guru)
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('modal-tambah').classList.add('show')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Guru
        </button>
    </div>

    @if($guru->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Username</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guru as $i => $g)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $g->nama_guru }}</td>
                <td>{{ $g->user->username ?? '-' }}</td>
                <td><span class="badge badge-green">Aktif</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.guru.destroy', $g->id_guru) }}"
                          onsubmit="return confirm('Hapus guru {{ $g->nama_guru }}? Akun login terkait juga akan dihapus!')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41"/></svg>
        <p>Belum ada data guru. Klik <strong>Tambah Guru</strong> untuk menambahkan.</p>
    </div>
    @endif
</div>

{{-- Modal Tambah Guru --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-title">Tambah Guru Baru</div>
        <form method="POST" action="{{ route('admin.guru.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Guru <span class="required">*</span></label>
                <input type="text" name="nama_guru" class="form-control" placeholder="Nama lengkap guru" required>
            </div>
            <div class="form-group">
                <label>Username Login <span class="required">*</span></label>
                <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
            </div>
            <div class="form-group">
                <label>Password <span class="required">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="document.getElementById('modal-tambah').classList.remove('show')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
