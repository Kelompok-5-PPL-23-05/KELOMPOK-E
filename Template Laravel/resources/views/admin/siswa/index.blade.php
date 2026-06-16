@extends('admin.layout')

@section('title', 'Data Siswa')

@section('content')
<h1 class="page-title">Data Siswa</h1>
<p class="page-subtitle">Kelola data seluruh siswa PKBM</p>

<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">
            <button class="btn btn-success" onclick="document.getElementById('modal-upload').classList.add('show')">
                Upload Data Master (CSV)
            </button>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            Daftar Siswa ({{ $siswa->count() }} siswa)
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('modal-tambah').classList.add('show')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Siswa
        </button>
    </div>

    @if($siswa->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $i => $s)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td><span class="badge badge-blue">{{ $s->kelas->nama_kelas ?? '-' }}</span></td>
                <td>
                    <div class="action-btns">
                        <button class="btn btn-sm btn-warning"
                            onclick="openEdit({{ $s->id_siswa }}, '{{ addslashes($s->nama_siswa) }}', {{ $s->Kelasid_kelas }})">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.siswa.destroy', $s->id_siswa) }}"
                              onsubmit="return confirm('Hapus siswa {{ $s->nama_siswa }}?')">
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
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
        <p>Belum ada data siswa. Klik <strong>Tambah Siswa</strong> untuk menambahkan.</p>
    </div>
    @endif
</div>

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-title">Tambah Siswa Baru</div>
        <form method="POST" action="{{ route('admin.siswa.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Siswa <span class="required">*</span></label>
                <input type="text" name="nama_siswa" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="form-group">
                <label>Kelas <span class="required">*</span></label>
                <select name="Kelasid_kelas" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN siswa">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat siswa">
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
        <div class="modal-title">Edit Data Siswa</div>
        <form method="POST" id="form-edit" action="">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Siswa <span class="required">*</span></label>
                <input type="text" name="nama_siswa" id="edit-nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kelas <span class="required">*</span></label>
                <select name="Kelasid_kelas" id="edit-kelas" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
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
            <span style="font-size:16px; font-weight:700;">Upload Data Master Siswa</span>
            <button type="button" onclick="document.getElementById('modal-upload').classList.remove('show')" style="background:none;border:none;cursor:pointer;font-size:20px;color:#888;line-height:1;">&#x2715;</button>
        </div>
        <form method="POST" action="{{ route('admin.siswa.import.preview') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label style="font-size:13px; font-weight:600; margin-bottom:8px; display:block;">File CSV Siswa <span style="color:#c0392b;">*</span></label>
                <div style="border:1px solid #ccd6e4; border-radius:8px; padding:10px 14px; background:#fafbfc;">
                    <input type="file" name="file_master" accept=".csv" required
                        style="width:100%; font-size:13px; font-family:'Poppins',sans-serif; border:none; background:transparent; outline:none; cursor:pointer;">
                </div>
                <div style="margin-top:12px; font-size:13px; color:#444; line-height:1.7;">
                    Pastikan urutan kolom CSV: <strong>Nama Siswa, Nama Kelas, NISN, Alamat</strong><br>
                    <span style="color:#888; font-style:italic;">Contoh baris: Ahmad Fauzi, Paket A Kelas 1, 1234567890, Jl. Merdeka No 5</span>
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
function openEdit(id, nama, kelasId) {
    document.getElementById('form-edit').action = '/admin/siswa/' + id;
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-kelas').value = kelasId;
    document.getElementById('modal-edit').classList.add('show');
}
</script>
@endsection
