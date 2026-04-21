@extends('admin.layout')

@section('title', 'Data Kelas')

@section('content')
<h1 class="page-title">Data Kelas</h1>
<p class="page-subtitle">Kelola kelas yang ada di PKBM</p>

<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
            Daftar Kelas
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('modal-tambah').classList.add('show')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Kelas
        </button>
    </div>

    @if($kelas->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Jumlah Siswa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas as $i => $k)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $k->nama_kelas }}</td>
                <td><span class="badge badge-count">{{ $k->siswa_count }} siswa</span></td>
                <td>
                    <div class="action-btns">
                        <button class="btn btn-sm btn-warning"
                            onclick="openEdit({{ $k->id_kelas }}, '{{ addslashes($k->nama_kelas) }}')">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.kelas.destroy', $k->id_kelas) }}"
                              onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }}? Semua siswa di kelas ini juga akan terhapus!')">
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
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/></svg>
        <p>Belum ada data kelas. Klik <strong>Tambah Kelas</strong> untuk menambahkan.</p>
    </div>
    @endif
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-title">Tambah Kelas Baru</div>
        <form method="POST" action="{{ route('admin.kelas.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Kelas <span class="required">*</span></label>
                <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: Paket A, Paket B" required>
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
        <div class="modal-title">Edit Kelas</div>
        <form method="POST" id="form-edit" action="">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Kelas <span class="required">*</span></label>
                <input type="text" name="nama_kelas" id="edit-nama" class="form-control" required>
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
    document.getElementById('form-edit').action = '/admin/kelas/' + id;
    document.getElementById('edit-nama').value = nama;
    document.getElementById('modal-edit').classList.add('show');
}
</script>
@endsection
