@extends('admin.layout')

@section('title', 'Mata Pelajaran')

@section('content')
<h1 class="page-title">Mata Pelajaran</h1>
<p class="page-subtitle">Kelola daftar mata pelajaran di PKBM</p>

<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            Daftar Mata Pelajaran
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('modal-tambah').classList.add('show')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Mapel
        </button>
    </div>

    @if($mapel->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mata Pelajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mapel as $i => $m)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $m->nama_mapel }}</td>
                <td>
                    <div class="action-btns">
                        <button class="btn btn-sm btn-warning"
                            onclick="openEdit({{ $m->id_mapel }}, '{{ addslashes($m->nama_mapel) }}')">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.mapel.destroy', $m->id_mapel) }}"
                              onsubmit="return confirm('Hapus mata pelajaran {{ $m->nama_mapel }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25"/></svg>
        <p>Belum ada mata pelajaran. Klik <strong>Tambah Mapel</strong> untuk menambahkan.</p>
    </div>
    @endif
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-title">Tambah Mata Pelajaran</div>
        <form method="POST" action="{{ route('admin.mapel.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Mata Pelajaran <span class="required">*</span></label>
                <input type="text" name="nama_mapel" class="form-control" placeholder="Contoh: Bahasa Indonesia" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="document.getElementById('modal-tambah').classList.remove('show')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modal-edit">
    <div class="modal">
        <div class="modal-title">Edit Mata Pelajaran</div>
        <form method="POST" id="form-edit" action="">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Mata Pelajaran <span class="required">*</span></label>
                <input type="text" name="nama_mapel" id="edit-nama" class="form-control" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="document.getElementById('modal-edit').classList.remove('show')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openEdit(id, nama) {
    document.getElementById('form-edit').action = '/admin/mapel/' + id;
    document.getElementById('edit-nama').value = nama;
    document.getElementById('modal-edit').classList.add('show');
}
</script>
@endsection
