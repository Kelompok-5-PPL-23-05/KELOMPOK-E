<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa — E-Rapor PKBM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #a8b8cc;
            min-height: 100vh;
            display: flex;
            color: #000;
        }

        /* ════════════ SIDEBAR ════════════ */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #eef2f6;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            border-right: 1px solid #d0d8e4;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 40px 24px 20px;
        }
        .hamburger-btn {
            background: none; border: none; cursor: pointer;
            display: flex; flex-direction: column; gap: 5px; padding: 0;
        }
        .hamburger-btn span {
            display: block; width: 24px; height: 3px;
            background: #000; border-radius: 3px;
        }
        .sidebar-brand { font-size: 20px; font-weight: 700; color: #000; }
        .sidebar-search { padding: 0 20px 16px; }
        .search-box {
            display: flex; align-items: center; justify-content: space-between;
            background: transparent; border: 1px solid #6c8bbf;
            border-radius: 20px; padding: 8px 16px;
        }
        .search-box input {
            border: none; background: transparent; outline: none;
            font-size: 13px; font-family: 'Poppins', sans-serif;
            color: #000; width: 100%;
        }
        .search-box input::placeholder { color: #333; }
        .search-box svg { width: 16px; height: 16px; color: #6c8bbf; flex-shrink: 0; }

        .nav-menu { flex: 1; padding: 0; border-top: 1px solid #9fb3ce; }
        .nav-section { border-bottom: 1px solid #9fb3ce; }
        .nav-section-title {
            display: flex; align-items: center; padding: 12px 20px;
            font-size: 14px; font-weight: 400; color: #000;
            cursor: pointer; user-select: none;
        }
        .nav-section-title .arrow {
            width: 16px; height: 16px; margin-right: 10px;
            transition: transform 0.2s ease;
            transform: rotate(-90deg); flex-shrink: 0;
        }
        .nav-section-title.open .arrow { transform: rotate(0deg); }
        .nav-children { display: none; padding-bottom: 8px; }
        .nav-children.open { display: block; }
        .nav-child-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 20px 8px 40px; font-size: 13.5px;
            font-weight: 400; cursor: pointer; text-decoration: none;
            color: #000; transition: background-color 0.15s;
        }
        .nav-child-item:hover { background-color: #dde4ee; }
        .nav-child-item.active { background-color: #ccd6e4; font-weight: 600; }
        .nav-item-single {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 20px; font-size: 14px; font-weight: 400;
            cursor: pointer; text-decoration: none; color: #000;
            border-bottom: 1px solid #9fb3ce; transition: background-color 0.15s;
        }
        .nav-item-single:hover { background-color: #dde4ee; }
        .nav-item-single.active { background-color: #ccd6e4; font-weight: 600; }
        .nav-item-single .nav-icon { width: 16px; height: 16px; flex-shrink: 0; }
        .sidebar-footer { padding: 30px 20px; margin-top: auto; }
        .logout-btn {
            background: none; border: none; font-size: 14px; font-weight: 400;
            color: #000; cursor: pointer; font-family: 'Poppins', sans-serif;
            text-align: left; margin-left: 20px;
        }

        /* ════════════ MAIN CONTENT ════════════ */
        .main-content { flex: 1; padding: 50px 30px; overflow-y: auto; }
        .page-title { font-size: 22px; font-weight: 700; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: #444; margin-bottom: 30px; }

        /* Alert */
        .alert {
            padding: 14px 20px; border-radius: 8px;
            margin-bottom: 24px; font-size: 14px; font-weight: 500;
        }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* Buttons */
        .btn {
            border: none; border-radius: 8px; padding: 10px 22px;
            font-size: 13px; font-weight: 600; font-family: 'Poppins', sans-serif;
            cursor: pointer; transition: all 0.15s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn svg { width: 14px; height: 14px; }
        .btn-primary { background-color: #4a6fa5; color: #fff; }
        .btn-primary:hover { background-color: #3b5d8a; }
        .btn-danger { background-color: #c0392b; color: #fff; }
        .btn-danger:hover { background-color: #a93226; }
        .btn-cancel { background-color: #d0d8e4; color: #333; }
        .btn-cancel:hover { background-color: #bcc8d8; }
        .btn-sm { padding: 7px 14px; font-size: 12px; }

        /* Table */
        .table-wrapper {
            background: #fff; border-radius: 10px; overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-bottom: 30px;
        }
        .table-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 18px 24px; border-bottom: 1px solid #eee;
        }
        .table-title { font-size: 15px; font-weight: 700; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th {
            background-color: #4a6fa5; color: #fff;
            padding: 13px 16px; text-align: left;
            font-size: 13px; font-weight: 600;
        }
        .data-table thead th:first-child { text-align: center; width: 50px; }
        .data-table tbody td {
            padding: 13px 16px; font-size: 13.5px;
            border-bottom: 1px solid #f0f0f0;
        }
        .data-table tbody td:first-child { text-align: center; color: #888; font-weight: 600; }
        .data-table tbody tr:hover { background-color: #f5f8fb; }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .action-btns { display: flex; gap: 6px; }

        /* Badge */
        .badge {
            display: inline-block; padding: 3px 12px;
            border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .badge-blue { background: #d1ecf1; color: #0c5460; }

        /* Empty state */
        .empty-state { text-align: center; padding: 50px 20px; color: #888; }
        .empty-state svg { width: 48px; height: 48px; margin-bottom: 12px; opacity: 0.4; }
        .empty-state p { font-size: 14px; }

        /* Modal */
        .modal-overlay {
            display: none; position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4); z-index: 999;
            justify-content: center; align-items: center;
        }
        .modal-overlay.show { display: flex; }
        .modal {
            background: #fff; border-radius: 12px; padding: 32px;
            width: 100%; max-width: 440px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.12);
        }
        .modal-title {
            font-size: 17px; font-weight: 700; margin-bottom: 24px;
            padding-bottom: 16px; border-bottom: 1px solid #eee;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block; font-size: 13px; font-weight: 600;
            margin-bottom: 6px; color: #333;
        }
        .form-group label .required { color: #c0392b; }
        .form-control, .form-select {
            width: 100%; padding: 11px 14px; border: 1px solid #ccd6e4;
            border-radius: 8px; font-size: 14px;
            font-family: 'Poppins', sans-serif; outline: none;
            transition: border-color 0.15s; background: #fff;
        }
        .form-control:focus, .form-select:focus { border-color: #4a6fa5; }
        .form-select {
            appearance: none;
            background: #fff url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23000' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
            background-size: 14px;
        }
        .modal-actions {
            display: flex; justify-content: flex-end; gap: 10px;
            margin-top: 24px; padding-top: 16px; border-top: 1px solid #eee;
        }

        /* Konfirmasi hapus */
        .confirm-text { font-size: 14px; color: #444; margin-bottom: 8px; }
        .confirm-name { font-weight: 700; color: #000; }
    </style>
</head>
<body>

    <!-- ════════════ SIDEBAR ════════════ -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <button class="hamburger-btn">
                <span></span><span></span><span></span>
            </button>
            <span class="sidebar-brand">E-Rapor</span>
        </div>

        <div class="sidebar-search">
            <div class="search-box">
                <input type="text" placeholder="Cari">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-width="2"/>
                </svg>
            </div>
        </div>

        <div class="nav-menu">

            <!-- Akun Pengguna -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this, 'c-akun')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Akun Pengguna
                </div>
                <div class="nav-children" id="c-akun">
                    <span class="nav-child-item">Informasi Pengguna</span>
                    <span class="nav-child-item">Ubah Kata Sandi</span>
                </div>
            </div>

            <!-- Data Siswa (aktif) -->
            <div class="nav-section">
                <div class="nav-section-title open" onclick="toggleNav(this, 'c-siswa')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Data Siswa
                </div>
                <div class="nav-children open" id="c-siswa">
                    <a href="{{ route('admin.siswa') }}" class="nav-child-item active">Daftar Siswa</a>
                    <a href="{{ route('admin.siswa') }}" class="nav-child-item" onclick="event.preventDefault(); document.getElementById('modal-tambah').classList.add('show')">Tambah Siswa</a>
                </div>
            </div>

            <!-- Data Kelas -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this, 'c-kelas')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Data Kelas
                </div>
                <div class="nav-children" id="c-kelas">
                    <span class="nav-child-item">Daftar Kelas</span>
                    <span class="nav-child-item">Tambah Kelas</span>
                </div>
            </div>

            <!-- Data Guru -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this, 'c-guru')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Data Guru
                </div>
                <div class="nav-children" id="c-guru">
                    <span class="nav-child-item">Daftar Guru</span>
                    <span class="nav-child-item">Tambah Guru</span>
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this, 'c-mapel')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Mata Pelajaran
                </div>
                <div class="nav-children" id="c-mapel">
                    <span class="nav-child-item">Daftar Mapel</span>
                    <span class="nav-child-item">Tambah Mapel</span>
                </div>
            </div>

            <!-- Lembaga -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this, 'c-lembaga')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Lembaga
                </div>
                <div class="nav-children" id="c-lembaga">
                    <span class="nav-child-item">Profil Lembaga</span>
                </div>
            </div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="nav-item-single">
                Dashboard
            </a>

            <!-- Rapor Siswa -->
            <a href="{{ route('dashboard') }}" class="nav-item-single" style="border-bottom:none;">
                Rapor Siswa
            </a>

        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- ════════════ MAIN CONTENT ════════════ -->
    <main class="main-content">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error){{ $error }}<br>@endforeach
            </div>
        @endif

        <h1 class="page-title">Data Siswa</h1>
        <p class="page-subtitle">Kelola data siswa E-Rapor PKBM.</p>

        <div class="table-wrapper">
            <div class="table-header">
                <div class="table-title">Daftar Siswa</div>
                <button class="btn btn-primary" onclick="document.getElementById('modal-tambah').classList.add('show')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Tambah Siswa
                </button>
            </div>

            @if($siswaList->count() > 0)
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
                    @foreach($siswaList as $i => $s)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $s->nama_siswa }}</td>
                        <td>
                            <span class="badge badge-blue">{{ $s->kelas->nama_kelas ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-danger btn-sm"
                                    onclick="konfirmasiHapus({{ $s->id_siswa }}, '{{ addslashes($s->nama_siswa) }}')">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                <p>Belum ada data siswa. Klik <strong>Tambah Siswa</strong> untuk menambahkan.</p>
            </div>
            @endif
        </div>
    </main>

    <!-- ════════════ MODAL TAMBAH SISWA ════════════ -->
    <div class="modal-overlay" id="modal-tambah">
        <div class="modal">
            <div class="modal-title">Tambah Siswa Baru</div>
            <form method="POST" action="{{ route('admin.siswa.store') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Siswa <span class="required">*</span></label>
                    <input type="text" name="nama_siswa" class="form-control"
                        placeholder="Masukkan nama lengkap siswa"
                        value="{{ old('nama_siswa') }}" required>
                </div>
                <div class="form-group">
                    <label>Kelas <span class="required">*</span></label>
                    <select name="Kelasid_kelas" class="form-select" required>
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id_kelas }}"
                                {{ old('Kelasid_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel"
                        onclick="document.getElementById('modal-tambah').classList.remove('show')">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ════════════ MODAL KONFIRMASI HAPUS ════════════ -->
    <div class="modal-overlay" id="modal-hapus">
        <div class="modal">
            <div class="modal-title">Konfirmasi Hapus</div>
            <p class="confirm-text">Yakin ingin menghapus siswa:</p>
            <p class="confirm-name" id="hapus-nama-siswa"></p>
            <p class="confirm-text" style="margin-top:8px; font-size:13px; color:#c0392b;">
                Data yang dihapus tidak dapat dikembalikan.
            </p>
            <form method="POST" id="form-hapus">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel"
                        onclick="document.getElementById('modal-hapus').classList.remove('show')">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle sidebar nav
        function toggleNav(titleEl, childId) {
            titleEl.classList.toggle('open');
            document.getElementById(childId).classList.toggle('open');
        }

        // Tutup modal klik backdrop
        document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) overlay.classList.remove('show');
            });
        });

        // Buka modal hapus & set action form
        function konfirmasiHapus(id, nama) {
            document.getElementById('hapus-nama-siswa').textContent = nama;
            document.getElementById('form-hapus').action = '/admin/siswa/' + id;
            document.getElementById('modal-hapus').classList.add('show');
        }

        // Buka kembali modal tambah jika ada error validasi
        @if($errors->any())
            document.getElementById('modal-tambah').classList.add('show');
        @endif

        // Auto buka modal jika URL mengandung #tambah
        if (window.location.hash === '#tambah') {
            document.getElementById('modal-tambah').classList.add('show');
        }
    </script>
</body>
</html>