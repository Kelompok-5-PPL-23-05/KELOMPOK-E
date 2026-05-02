<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lembaga — E-Rapor PKBM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background-color: #a8b8cc; min-height: 100vh; display: flex; color: #000; }
        .sidebar { width: 250px; min-height: 100vh; background-color: #eef2f6; display: flex; flex-direction: column; flex-shrink: 0; border-right: 1px solid #d0d8e4; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .sidebar-header { display: flex; align-items: center; gap: 16px; padding: 40px 24px 20px; }
        .hamburger-btn { background: none; border: none; cursor: pointer; display: flex; flex-direction: column; gap: 5px; padding: 0; }
        .hamburger-btn span { display: block; width: 24px; height: 3px; background: #000; border-radius: 3px; }
        .sidebar-brand { font-size: 20px; font-weight: 700; color: #000; }
        .sidebar-search { padding: 0 20px 16px; }
        .search-box { display: flex; align-items: center; justify-content: space-between; background: transparent; border: 1px solid #6c8bbf; border-radius: 20px; padding: 8px 16px; }
        .search-box input { border: none; background: transparent; outline: none; font-size: 13px; font-family: 'Poppins', sans-serif; color: #000; width: 100%; }
        .search-box input::placeholder { color: #333; }
        .search-box svg { width: 16px; height: 16px; color: #6c8bbf; flex-shrink: 0; }
        .nav-menu { flex: 1; padding: 0; border-top: 1px solid #9fb3ce; }
        .nav-section { border-bottom: 1px solid #9fb3ce; }
        .nav-section-title { display: flex; align-items: center; padding: 12px 20px; font-size: 14px; font-weight: 400; color: #000; cursor: pointer; user-select: none; }
        .nav-section-title .arrow { width: 16px; height: 16px; margin-right: 10px; transition: transform 0.2s ease; transform: rotate(-90deg); flex-shrink: 0; }
        .nav-section-title.open .arrow { transform: rotate(0deg); }
        .nav-children { display: none; padding-bottom: 8px; }
        .nav-children.open { display: block; }
        .nav-child-item { display: flex; align-items: center; gap: 10px; padding: 8px 20px 8px 40px; font-size: 13.5px; font-weight: 400; cursor: pointer; text-decoration: none; color: #000; transition: background-color 0.15s; }
        .nav-child-item:hover { background-color: #dde4ee; }
        .nav-child-item.active { background-color: #ccd6e4; font-weight: 600; }
        .nav-item-single { display: flex; align-items: center; gap: 10px; padding: 12px 20px; font-size: 14px; font-weight: 400; cursor: pointer; text-decoration: none; color: #000; border-bottom: 1px solid #9fb3ce; transition: background-color 0.15s; }
        .nav-item-single:hover { background-color: #dde4ee; }
        .sidebar-footer { padding: 30px 20px; margin-top: auto; }
        .logout-btn { background: none; border: none; font-size: 14px; font-weight: 400; color: #000; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: left; margin-left: 20px; }

        .main-content { flex: 1; padding: 50px 30px; overflow-y: auto; }
        .page-title { font-size: 22px; font-weight: 700; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: #444; margin-bottom: 30px; }
        .alert { padding: 14px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .form-card { background: #fff; border-radius: 10px; padding: 32px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); max-width: 640px; }
        .form-card-title { font-size: 15px; font-weight: 700; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #eee; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #333; }
        .required { color: #c0392b; }
        .form-control, .form-textarea { width: 100%; padding: 11px 14px; border: 1px solid #ccd6e4; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif; outline: none; transition: border-color 0.15s; background: #fff; color: #000; }
        .form-control:focus, .form-textarea:focus { border-color: #4a6fa5; }
        .form-textarea { resize: vertical; min-height: 90px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn { border: none; border-radius: 8px; padding: 11px 28px; font-size: 13px; font-weight: 600; font-family: 'Poppins', sans-serif; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn svg { width: 15px; height: 15px; }
        .btn-primary { background-color: #4a6fa5; color: #fff; }
        .btn-primary:hover { background-color: #3b5d8a; }
        .btn-cancel { background-color: #d0d8e4; color: #333; }
        .btn-cancel:hover { background-color: #bcc8d8; }
        .form-actions { margin-top: 28px; padding-top: 20px; border-top: 1px solid #eee; display: flex; gap: 10px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <button class="hamburger-btn"><span></span><span></span><span></span></button>
            <span class="sidebar-brand">E-Rapor</span>
        </div>
        <div class="sidebar-search">
            <div class="search-box">
                <input type="text" placeholder="Cari">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-width="2"/></svg>
            </div>
        </div>
        <div class="nav-menu">
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this,'c-akun')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Akun Pengguna
                </div>
                <div class="nav-children" id="c-akun">
                    <span class="nav-child-item">Informasi Pengguna</span>
                    <span class="nav-child-item">Ubah Kata Sandi</span>
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this,'c-siswa')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Data Siswa
                </div>
                <div class="nav-children" id="c-siswa">
                    <a href="{{ route('admin.siswa') }}" class="nav-child-item">Daftar Siswa</a>
                    <a href="{{ route('admin.siswa') }}#tambah" class="nav-child-item">Tambah Siswa</a>
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this,'c-kelas')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Data Kelas
                </div>
                <div class="nav-children" id="c-kelas">
                    <span class="nav-child-item">Daftar Kelas</span>
                    <span class="nav-child-item">Tambah Kelas</span>
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this,'c-guru')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Data Guru
                </div>
                <div class="nav-children" id="c-guru">
                    <span class="nav-child-item">Daftar Guru</span>
                    <span class="nav-child-item">Tambah Guru</span>
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-section-title" onclick="toggleNav(this,'c-mapel')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Mata Pelajaran
                </div>
                <div class="nav-children" id="c-mapel">
                    <span class="nav-child-item">Daftar Mapel</span>
                    <span class="nav-child-item">Tambah Mapel</span>
                </div>
            </div>
            <!-- Lembaga (aktif di Edit) -->
            <div class="nav-section">
                <div class="nav-section-title open" onclick="toggleNav(this,'c-lembaga')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Lembaga
                </div>
                <div class="nav-children open" id="c-lembaga">
                    <a href="{{ route('admin.lembaga') }}" class="nav-child-item">Profil Lembaga</a>
                    <a href="{{ route('admin.lembaga.edit') }}" class="nav-child-item active">Edit Lembaga</a>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item-single">Dashboard</a>
            <a href="{{ route('dashboard') }}" class="nav-item-single" style="border-bottom:none;">Rapor Siswa</a>
        </div>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error){{ $error }}<br>@endforeach
            </div>
        @endif

        <h1 class="page-title">Edit Lembaga</h1>
        <p class="page-subtitle">Perbarui informasi lembaga E-Rapor PKBM.</p>

        <div class="form-card">
            <div class="form-card-title">Informasi Lembaga</div>
            <form method="POST" action="{{ route('admin.lembaga.update') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Lembaga <span class="required">*</span></label>
                    <input type="text" name="nama_lembaga" class="form-control"
                        placeholder="Contoh: PKBM Harapan Bangsa"
                        value="{{ old('nama_lembaga', $lembaga->nama_lembaga ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Alamat <span class="required">*</span></label>
                    <textarea name="alamat" class="form-textarea"
                        placeholder="Masukkan alamat lengkap lembaga" required>{{ old('alamat', $lembaga->alamat ?? '') }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>No. Telepon <span class="required">*</span></label>
                        <input type="text" name="no_telepon" class="form-control"
                            placeholder="Contoh: 08123456789"
                            value="{{ old('no_telepon', $lembaga->no_telepon ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control"
                            placeholder="Contoh: info@pkbm.sch.id"
                            value="{{ old('email', $lembaga->email ?? '') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kepala Lembaga <span class="required">*</span></label>
                    <input type="text" name="kepala_lembaga" class="form-control"
                        placeholder="Nama kepala lembaga"
                        value="{{ old('kepala_lembaga', $lembaga->kepala_lembaga ?? '') }}" required>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.lembaga') }}" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function toggleNav(titleEl, childId) {
            titleEl.classList.toggle('open');
            document.getElementById(childId).classList.toggle('open');
        }
    </script>
</body>
</html>