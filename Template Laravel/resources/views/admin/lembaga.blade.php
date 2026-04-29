<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Lembaga — E-Rapor PKBM</title>
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
        .nav-item-single.active { background-color: #ccd6e4; font-weight: 600; }
        .sidebar-footer { padding: 30px 20px; margin-top: auto; }
        .logout-btn { background: none; border: none; font-size: 14px; font-weight: 400; color: #000; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: left; margin-left: 20px; }
        .main-content { flex: 1; padding: 50px 30px; overflow-y: auto; }
        .page-title { font-size: 22px; font-weight: 700; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: #444; margin-bottom: 30px; }
        .alert { padding: 14px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* Profil Card */
        .profil-card { background: #fff; border-radius: 10px; padding: 32px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); max-width: 640px; }
        .profil-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #eee; }
        .profil-card-title { font-size: 15px; font-weight: 700; }
        .profil-row { display: flex; flex-direction: column; gap: 18px; }
        .profil-item { display: grid; grid-template-columns: 160px 1fr; gap: 12px; align-items: start; }
        .profil-label { font-size: 13px; font-weight: 600; color: #666; padding-top: 2px; }
        .profil-value { font-size: 14px; color: #000; font-weight: 400; line-height: 1.5; }
        .profil-empty { font-size: 13px; color: #aaa; font-style: italic; }
        .divider { border: none; border-top: 1px solid #f0f0f0; margin: 4px 0; }

        .btn { border: none; border-radius: 8px; padding: 9px 22px; font-size: 13px; font-weight: 600; font-family: 'Poppins', sans-serif; cursor: pointer; transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn svg { width: 14px; height: 14px; }
        .btn-primary { background-color: #4a6fa5; color: #fff; }
        .btn-primary:hover { background-color: #3b5d8a; }

        .empty-lembaga { text-align: center; padding: 50px 20px; color: #888; }
        .empty-lembaga svg { width: 48px; height: 48px; margin-bottom: 12px; opacity: 0.3; }
        .empty-lembaga p { font-size: 14px; margin-bottom: 16px; }
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
            <div class="nav-section">
                <div class="nav-section-title open" onclick="toggleNav(this,'c-lembaga')">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Lembaga
                </div>
                <div class="nav-children open" id="c-lembaga">
                    <a href="{{ route('admin.lembaga') }}" class="nav-child-item active">Profil Lembaga</a>
                    <a href="{{ route('admin.lembaga.edit') }}" class="nav-child-item">Edit Lembaga</a>
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

        <h1 class="page-title">Profil Lembaga</h1>
        <p class="page-subtitle">Informasi data lembaga E-Rapor PKBM.</p>

        <div class="profil-card">
            <div class="profil-card-header">
                <div class="profil-card-title">Informasi Lembaga</div>
                <a href="{{ route('admin.lembaga.edit') }}" class="btn btn-primary">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                    </svg>
                    Edit
                </a>
            </div>

            @if($lembaga)
            <div class="profil-row">
                <div class="profil-item">
                    <span class="profil-label">Nama Lembaga</span>
                    <span class="profil-value">{{ $lembaga->nama_lembaga }}</span>
                </div>
                <hr class="divider">
                <div class="profil-item">
                    <span class="profil-label">Alamat</span>
                    <span class="profil-value">{{ $lembaga->alamat }}</span>
                </div>
                <hr class="divider">
                <div class="profil-item">
                    <span class="profil-label">No. Telepon</span>
                    <span class="profil-value">{{ $lembaga->no_telepon }}</span>
                </div>
                <hr class="divider">
                <div class="profil-item">
                    <span class="profil-label">Email</span>
                    <span class="profil-value">{{ $lembaga->email }}</span>
                </div>
                <hr class="divider">
                <div class="profil-item">
                    <span class="profil-label">Kepala Lembaga</span>
                    <span class="profil-value">{{ $lembaga->kepala_lembaga }}</span>
                </div>
            </div>
            @else
            <div class="empty-lembaga">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/>
                </svg>
                <p>Data lembaga belum diisi.</p>
                <a href="{{ route('admin.lembaga.edit') }}" class="btn btn-primary">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Isi Data Lembaga
                </a>
            </div>
            @endif
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