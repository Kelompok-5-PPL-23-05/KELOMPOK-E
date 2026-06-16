@extends('admin.layout')

@section('title', 'Data Mata Pelajaran')

@section('content')
<h1 class="page-title">Data Mata Pelajaran</h1>
<p class="page-subtitle">Kelola mata pelajaran yang ada di PKBM</p>

<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">
            <button class="btn btn-success" onclick="document.getElementById('modal-upload').classList.add('show')">
                Upload Data Master (CSV)
            </button>
            <form action="{{ route('admin.mapel.destroyAll') }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA data mata pelajaran? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="margin-left: 10px;">
                    Hapus Semua
                </button>
            </form>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="margin-left: 10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            Daftar Mata Pelajaran ({{ $mapel->count() }} mapel)
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
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
        <p>Belum ada data mata pelajaran. Klik <strong>Tambah Mapel</strong> untuk menambahkan.</p>
    </div>
    @endif
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-title">Tambah Mata Pelajaran Baru</div>
        <form method="POST" action="{{ route('admin.mapel.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Mata Pelajaran <span class="required">*</span></label>
                <input type="text" name="nama_mapel" class="form-control" placeholder="Contoh: Matematika" required>
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

{{-- Modal Upload Data Master --}}
<div class="modal-overlay" id="modal-upload">
    <div class="modal" style="max-width: 560px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid #eee;">
            <span style="font-size:16px; font-weight:700;">Upload Data Master Mapel</span>
            <button type="button" onclick="document.getElementById('modal-upload').classList.remove('show')" style="background:none;border:none;cursor:pointer;font-size:20px;color:#888;line-height:1;">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('admin.mapel.import.preview') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label style="font-size:13px; font-weight:600; margin-bottom:8px; display:block;">File CSV Mapel <span style="color:#c0392b;">*</span></label>
                <div style="border:1px solid #ccd6e4; border-radius:8px; padding:10px 14px; background:#fafbfc;">
                    <input type="file" name="file_master" accept=".csv" required
                        style="width:100%; font-size:13px; font-family:'Poppins',sans-serif; border:none; background:transparent; outline:none; cursor:pointer;">
                </div>
                <div style="margin-top:12px; font-size:13px; color:#444; line-height:1.7;">
                    Pastikan urutan kolom CSV: <strong>Nama Mata Pelajaran</strong><br>
                    <span style="color:#888; font-style:italic;">Contoh baris: Bahasa Indonesia</span>
                </div>
            </div>
            <div style="margin-top:20px;">
                <button type="submit"
                    style="width:100%; background:#3d5a8a; color:#fff; border:none; border-radius:8px; padding:13px 20px; font-size:14px; font-weight:600; font-family:'Poppins',sans-serif; cursor:pointer; transition:background 0.15s;"
                    onmouseover="this.style.background='#2e4570'" onmouseout="this.style.background='#3d5a8a'">
                    Lanjut ke Preview
                </button>
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
